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

### [ ] 5. Legacy `defaults.json`-Pfad in `pwConfig::load()` entfernen

**Problem**: `pwConfig::load()` hat ~30 Zeilen Legacy-Handling für alte `defaults.json`-Files (Pre-Projectwizard). Weder Packagist-Version noch pluginsources-Version der kirbyblock-* hat noch eins.

**Voraussetzung**: prüfen ob externe/User-Plugins darauf angewiesen sind. Wenn nein → entfernen.

**Test**: alle Blocks in claude visuell prüfen.

---

### [ ] 6. Zwei Override-Formate konsolidieren

**Problem**: `pwConfig::load()` akzeptiert
- `$cfg['tabs']` (flat)
- `$cfg['settings']['tabs']` (wrapped)

Zwischenzustand alter Migration.

**Ziel**: Ein Format wählen (wrapped ist konsistenter), Migrations-Script für existierende JSONs. `pwConfig::load()` akzeptiert nur noch das eine Format.

**Test**: nach Migration in claude/rh/encom die overrides.json prüfen; visuellen Vergleich.

---

### [x] 7. `method_exists()`-Checks in projectbuilder.php entfernen  ✅ 2026-09-15 (mit Punkt 1)

**Problem**: `method_exists('pwConfig', 'tailwindSetup')` und `method_exists('pwConfig', 'panelColorsSetup')` sind Version-Skew-Toleranz. Bei projekt-lokaler projectbuilder.php + älterem Plugin plausibel — nach TODO 1 (projectbuilder.php als Wrapper) sind sie obsolet.

**Test**: automatisch mitgeprüft durch TODO 1.

---

## Priorität 3 — Struktur/Naming

### [ ] 8. Config-Reader konsolidieren

**Problem**: Drei parallele Wege in `pwConfig`:
- `projectConfig("kirbyblocks.pwtext")` — Dot-Notation
- `navConfig()` / `footerConfig()` — spezialisiert
- `tailwindSetup()` liest configs direkt selbst nochmal

**Ziel**: eine Reader-Facade. `navConfig` / `footerConfig` bleiben als Convenience-Wrapper.

**Test**: alle Config-abhängigen Bereiche visuell (Nav, Footer, Blocks).

---

### [ ] 9. `ProjectConfig::detectBlocks()` über `pwConfig::registered()`

**Problem**: Aktuell Filesystem-Scan über `site/plugins/*/src/config/settings.json`. Registry wäre schneller und deterministischer.

**Ziel**: Registry als primäre Quelle, Filesystem-Scan als Fallback für nicht-registrierte Blocks.

**Test**: Panel > Project Wizard > Overview zeigt alle Blocks. Aktivieren, Speichern, Frontend-Render.

---

### [ ] 10. Zwei ähnlich benannte Config-Klassen entwirren

**Problem**: `pwConfig` (pagewizard, Runtime) und `ProjectConfig` (projectwizard, Panel-API) — Naming führt zu Verwirrung, beide lesen die gleichen Files, teilweise mit unterschiedlicher Merge-Semantik.

**Ziel**: gemeinsame Facade oder klarer Namespace-Split. Backward-compat via Aliase.

**Test**: Panel-Overview + alle Frontend-Blocks.

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
