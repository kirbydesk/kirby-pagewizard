# TODO — Refactoring / Verbesserungen

Konsolidierte Liste der Verbesserungs-Vorschläge aus der Plugin-Analyse (Session 2026-09-14/15). Wird punktweise abgearbeitet — nach jedem Punkt visueller/CSS-Diff-Test gegen Live-Referenz, damit nichts bricht.

**Betroffene Repos:** `kirby-pagewizard`, `kirby-projectwizard`, `kirbyblock-*` (11 Plugins insgesamt).

**Test-Basis:** `claude` (Symlink-Zwilling auf pluginsources — Änderungen greifen sofort) und Diff gegen Live-CSS (rh, encom).

---

## Priorität 1 — Wartungslast reduzieren

### [x] 1. projectbuilder.php reduzieren auf minimalen Wrapper  ✅ 2026-09-15

**Problem**: `src/scaffold/copy/projectbuilder.php` hat 297 Zeilen Logik direkt im Projekt-Root. Jedes Projekt hat eine eigene Kopie, die von der Plugin-Version divergieren kann (heute erlebt: der Reflection-Workaround war im Projekt, der Plugin-Fix ersetzt ihn — aber der Workaround bleibt kleben).

**Ziel**: Neue Methode `pwConfig::runProjectBuilder()` in `src/helpers/blocks/config.php`, die die komplette Logik enthält. `projectbuilder.php` wird zu:
```php
<?php
return ['route:after' => fn() => pwConfig::runProjectBuilder()];
```

**Nutzen**: Zentrale Logik im Plugin, projekt-lokale Datei stabil und wartungsarm.

**Test**: nach Refactor `curl claude.test/de` → `storage/temp/vars.css` und `tailwind.css` prüfen (identisch zu vorher). `npm run build` → `site.min.css` Diff gegen vorherige Version.

---

### [x] 2. `pwBlueprint`-Helper  ✅ 2026-09-15

**Problem**: `kirbyblock-*/src/extensions/blueprints.php` sind zu ~80% identisch (Config-Load, Content-Tab-Assembly, Style/Layout/Grid/Settings-Tabs). Bei text 89 Zeilen, bei hero 144.

**Umsetzung**: `pwBlueprint::main($blockName, $builder)` in `src/helpers/blocks/blueprint.php` — kapselt Config-Load, Standard-Tabs, headlineContent-Header. Ergänzender `pwBlueprint::stdContent($cfg, ['tagline','heading','editor','buttons'])` als Preset-Factory für die häufigsten Content-Fields.

**Ergebnis**: 8 Main-Blueprints migriert, ~825 Zeilen weniger (1316 → 491, mit dem 178-Zeilen-Helper netto -647). Alle 22 Blueprint-JSONs byte-identisch verifiziert (8 Main + 14 Sub).

| Blueprint | vorher | nachher |
|---|---|---|
| text | 89 | 7 |
| quote | 59 | 21 |
| heading | 67 | 7 |
| media | 160 | 73 |
| featurelist | 118 | 43 |
| multicolumn | 433 | 249 |
| hero | 144 | 66 |
| cardlets | 246 | 157 |

---

### [x] 3. `pwSnippet`-Helper  ✅ 2026-09-15

**Problem**: Jedes `kirbyblock-*/snippets/index.php` hat identische data-*-Attribute-Generierung (margin, padding, radius, grid, style, block-size, fragment) — ~20 Zeilen pro Snippet.

**Umsetzung**: `pwSnippet::sectionOpen($blockName, $block, $settings, $extraAttrs='')`, `gridOpen()`, `gridClose()`, `sectionClose()`, `customCss($block)` in `src/helpers/blocks/snippet.php`.

**Ergebnis**: 8 Snippets migriert, ~250 Zeilen weniger (829 → 578). Alle byte-identisch verifiziert per curl-Diff gegen Snapshot.

| Snippet | vorher | nachher |
|---|---|---|
| text | 68 | 36 |
| quote | 51 | 19 |
| heading | 58 | 26 |
| media | 66 | 34 |
| featurelist | 101 | 68 |
| multicolumn | 122 | 91 |
| hero | 123 | 97 |
| cardlets | 240 | 207 |

---

### ~~[ ] 4. Boot-Order-Workaround zentralisieren~~  ❌ 2026-09-15 gestrichen

Composer-Autoload würde zentralisieren, funktioniert aber nur bei composer-installiertem Setup. Manuelle Installation (ZIP nach `site/plugins/` entpacken) soll weiterhin unterstützt bleiben — dafür bleibt der 6-Zeiler in jedem `kirbyblock-*/index.php` nötig. Kosmetische Reduzierung auf 3 Zeilen wäre möglich, aber keine echte Zentralisierung. Wir lassen es wie es ist.

---

## Priorität 2 — Legacy aufräumen

### [x] 5. Separates `defaults.json` entfernt  ✅ 2026-09-15

**Problem**: `pwConfig::load()` hat ~30 Zeilen Legacy-Handling für alte `defaults.json`-Files (Pre-Projectwizard). In pluginsources selbst nicht mehr genutzt, aber **encom hatte 2 aktive User-Plugins** (`site-monstercards`, `site-monstercall`), die darauf angewiesen waren.

**Umsetzung**:
1. Handler-Semantik (~25 Zeilen) beibehalten, aber die Datenquelle konsolidiert: `settings.json.defaults` (Top-Level-Key) statt separater `defaults.json`.
2. Beide encom-User-Plugins migriert: `defaults.json`-Inhalt nach `settings.json.defaults` verschoben, `defaults.json` gelöscht.
3. File-Fallback für separate `defaults.json` komplett entfernt.

**Ergebnis**: Ein-File-Config für alle Plugins. Panel-Blueprints der 2 migrierten Plugins byte-identisch, encom + claude Frontend byte-identisch. Falls je ein Plugin mit alter separater `defaults.json` auftaucht: 30-Sekunden-Copy in `settings.json.defaults`.

---

### [x] 6. Override-Format konsolidiert (nur wrapped)  ✅ 2026-09-15

**Problem**: `pwConfig::load()` akzeptierte
- `$cfg['tabs']`, `$cfg['fields']` (flat, wrapped) für tabs/fields
- `$cfg['defaults']`, `$cfg['editor']` immer flat — inkonsistent

Zwischenzustand alter Migration.

**Umsetzung**:
1. `pwConfig::load()` liest jetzt **nur** noch `$cfg['settings'][*]` — tabs, fields, defaults und editor müssen unter `settings` liegen.
2. `encom/site/config/pagewizard.php` migriert: für alle 8 Blöcke `defaults` und `editor` unter `settings` verschoben (Python-Skript, 853 Zeilen strukturell umformatiert).
3. `encom/site/config/projectwizard/overrides.json` migriert: `pwtext.editor` → `pwtext.settings.editor`.
4. Legacy-Fallback (`$cfg['tabs']` etc. auf Top-Level) komplett entfernt.

**Ergebnis**: Ein einheitliches Format. Alle 25 encom-Panel-Blueprints byte-identisch, alle 8 claude-Blueprints byte-identisch, beide Frontends byte-identisch.

---

### [x] 7. `method_exists()`-Checks in projectbuilder.php entfernen  ✅ 2026-09-15 (mit Punkt 1)

**Problem**: `method_exists('pwConfig', 'tailwindSetup')` und `method_exists('pwConfig', 'panelColorsSetup')` sind Version-Skew-Toleranz. Bei projekt-lokaler projectbuilder.php + älterem Plugin plausibel — nach TODO 1 (projectbuilder.php als Wrapper) sind sie obsolet.

**Test**: automatisch mitgeprüft durch TODO 1.

---

## Priorität 3 — Struktur/Naming

### [x] 8. Config-Reader konsolidiert  ✅ 2026-09-15

**Problem**: ~10× wiederholtes `file_exists ? json_decode(file_get_contents) : []`-Boilerplate — in `projectConfig()`, `navConfig()`, `footerConfig()`, `load()`, `tailwindSetup()`, `panelColorsSetup()`.

**Umsetzung**: Drei private I/O-Helper in `pwConfig`:
- `readJson($path, $default = [])` — sichere Read+Decode mit Default-Rückgabe
- `pluginConfig($name)` — liest aus pagewizard's `/config/<name>.json`
- `projectOverride($name)` — liest aus `site/config/projectwizard/<name>.json`
- `pluginDir()` — gecachte Pfad-Auflösung für pagewizard's Root

Alle Reader benutzen jetzt diese Helper. Ausnahme: in `tailwindSetup()` bleiben die **plugin-lokalen** JSONs (fonts, navigation, fontsizes, elements, footer) auf `$pluginDir` (Parameter) — bewusst, weil tailwindSetup pro Plugin läuft und für Nicht-pagewizard-Plugins keine Datei existiert (leerer Output). Für global/pagewizard-Wide Configs (global.json etc.) wird die Facade genutzt.

**Ergebnis**: -16 Zeilen netto in `config.php` (82 in / 98 out), klare Trennung zwischen Plugin-Default und Projekt-Override. Frontend/Blueprints/tailwind.css/vars.css in claude + encom byte-identisch verifiziert.

---

### [x] 9. `ProjectConfig::detectBlocks()` über `pwConfig::registered()`  ✅ 2026-09-15

**Problem**: Alter Ansatz war reiner Filesystem-Scan (`glob site/plugins/*`), gefolgt von regex-parse von `index.php` für den blockType. Die Registry (`pwConfig::registered()`) enthält bereits blockType → configDir und ist zur Zeit jedes bekannten Aufrufs (Panel-Areas + API) bereits vollständig.

**Umsetzung**: `detectBlocks()` nutzt jetzt **Registry primär** (kein Filesystem-Scan, keine regex-Extraktion), fällt danach auf glob-Scan **nur** für Plugins zurück, die noch nicht registriert sind. Metadaten-Extraktion (name, icon, package.json, i18n) in eine neue private `buildBlockInfo()`-Methode verschoben und wird beiden Wegen wiederverwendet. Zusätzlich per-Request-Cache — detectBlocks() wird aus mehreren Areas (api.php, areas.php, blockConfig()) aufgerufen; jetzt nur ein Scan pro Request.

**Ergebnis**: Kein Filesystem-Zugriff im Registry-Pfad, deterministische Reihenfolge, byte-identische Ausgabe. Frontend + Panel-Blueprints unverändert in claude + encom.

---

### [x] 10. Config-Klassen-Trennung dokumentiert + I/O konsolidiert  ✅ 2026-09-15

**Problem**: `pwConfig` und `ProjectConfig` lasen mit teils dupliziertem Boilerplate die gleichen JSON-Files (jede Klasse hatte ihre eigene private `readJson()`, ProjectConfig konstruierte `$pluginDir = kirby()->root('plugins') . '/kirby-pagewizard'` sechsmal von Hand).

**Umsetzung**:
1. `pwConfig`-I/O-Helper `readJson()`, `pluginConfig()`, `projectOverride()`, `pluginDir()` von `private` auf `public` gehoben, plus neuer `projectDir()`.
2. Kompletter Docstring am `ProjectConfig`-Klassenkopf, der die Aufgabentrennung fixiert: **reads → pwConfig, writes + Panel-CRUD → ProjectConfig**.
3. `ProjectConfig::readJson()` (dupliziert) entfernt — alle Aufrufer nutzen jetzt `pwConfig::readJson()`.
4. Die 6 `$pluginDir = kirby()->root('plugins') . '/kirby-pagewizard'; ... readJson($pluginDir . '/config/X.json')`-Blöcke durch `pwConfig::pluginConfig('X')` ersetzt (loadFooter, loadNavigation, loadElements, loadFontsizes, loadGlobal, loadFonts, scaffold).
5. `ProjectConfig::configDir()` delegiert an `pwConfig::projectDir()`.

**Ergebnis**: Eine Wahrheitsquelle für File-I/O, keine hardcoded `'/kirby-pagewizard'`-Pfade mehr in ProjectConfig, klarer Split. Frontend + Panel-API + Blueprints byte-identisch in claude + encom.

---

## Priorität 4 — Neue Erkenntnisse aus 2026-09-15

### [ ] 11. Update-Checkliste für Live-Projekte dokumentieren

**Problem**: Bei rh und encom haben wir Legacy-Files gefunden, die nach Plugin-Refactor obsolet wurden und aktiv Bugs verursachten:
- Alte CSS-Patches (hardcoded statt var-basiert) überschreiben neue Plugin-CSS
- Alte Snippet-Overrides in `site/snippets/blocks/*.php` blockieren neue Snippet-Version

**Ziel**: In `MIGRATION.md` (bereits in rh/encom vorhanden) einen Deprecation-Check-Schritt ergänzen: bei jedem Plugin-Update prüfen, welche Patches/Overrides ggf. obsolet sind (`_`-Prefix umschalten).

**Test**: nach Update ohne Deprecation-Check: bekanntes Symptom (font-sizes, fehlende Radius, alte HTML-Struktur).

---

### [ ] 12. Dev-Snapshot vs. Packagist-Divergenz vermeiden

**Problem**: 1.5.x-Files auf Dev-Rechner (nicht auf Packagist) verursachten heute massive Verwirrung. Der Rechner hatte manuell reinkopierte Dev-Snapshots, die weder mit Packagist noch mit lokalen composer.locks harmonierten.

**Ziel**: pluginsources und Packagist sollten immer synchron sein. Wenn Dev-Änderungen anstehen: kleine Version-Bumps + Packagist-Release. Keine "manuell auf Live-Rechner kopierten" Zwischenstände mehr.

**Test**: prozessuale Disziplin, kein Code-Test.

---

## Bereits erledigt (heute)

- ✅ `SetupWizard::npmBuild()` Node-PATH-Bug (v1.0.73)
- ✅ `pwConfig::tailwindSetup()` Guard-Bug (v1.1.35)
- ✅ Kirby 5.5: Divider-Icon (`icon: 'data:image/svg+xml,...'`) wird als Text gerendert — beide Divider (pagewizard `divider`, projectwizard `pw-divider`) auf `icon: 'blank'` umgestellt
- ✅ Punkt 1: `projectbuilder.php` → 2-Zeilen-Wrapper via `pwConfig::runProjectBuilder()`
- ✅ Punkt 7: `method_exists()`-Checks entfernt (mit Punkt 1)
- ✅ Punkt 3: `pwSnippet`-Helper — 8 Snippets migriert, 251 Zeilen weg, alle byte-identisch
- ✅ Punkt 2: `pwBlueprint`-Helper — 8 Blueprints migriert, 825 Zeilen weg, alle 22 JSONs byte-identisch
- ✅ Punkt 5: `settings.json.defaults` als konsolidierter Ersatz für separate `defaults.json`, 2 encom-User-Plugins migriert, Legacy-Fallback bleibt
- ✅ Punkt 6: Override-Format auf wrapped konsolidiert, encom pagewizard.php + overrides.json migriert, alle 25 Blueprints byte-identisch
- ✅ Punkt 8: Config-Reader konsolidiert — readJson/pluginConfig/projectOverride als I/O-Facade, -16 Zeilen netto
- ✅ Punkt 9: detectBlocks nutzt Registry primär, glob als Fallback, per-Request-Cache
- ✅ Punkt 10: pwConfig I/O-Helper public, ProjectConfig-Duplikation entfernt, Aufgabentrennung dokumentiert

## Bekannte Kleinigkeiten (nachziehen wenn Zeit)

- `detectBlocks()` icon-Extraktion via regex trifft den ersten `'icon' => '...'` in `blueprints.php`. Bei multicolumn ist das seit Punkt 2 (pwBlueprint-Refactor) der Sub-Block-Icon `title` statt Main-Block-Icon `layout-columns`. Panel-menu-Only, kein Frontend-Impact. Fix: `package.json.icon` in kirbyblock-multicolumn setzen (analog für alle 8 Plugins für Konsistenz).
