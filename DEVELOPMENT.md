# Development (Sandbox)

## npm install
Plugins in der Sandbox sind Symlinks nach kirbydesk. Damit der Build (kirbyup) Dependencies wie `marked` findet, muss `npm install` im Plugin-Verzeichnis ausgeführt werden:

```bash
cd site/plugins/kirby-pagewizard && npm install
```

## content.yml ignorieren
`blueprints/tabs/content.yml` wird im Sandbox-Betrieb mit Block-Einträgen gefüllt (z.B. `- pwtext`), soll aber im Repo leer bleiben. Nach einem frischen Clone lokal ignorieren:

```bash
cd site/plugins/kirby-pagewizard
git update-index --assume-unchanged blueprints/tabs/content.yml
```

## Release-Disziplin — keine Divergenz zwischen pluginsources und Packagist

**Grundregel:** Jede Änderung an einem Kirbydesk-Plugin geht via `pluginsources` → Commit → Tag → Push → Packagist. **Nie manuell** kopierte Dev-Snapshots in Projekt-Ordner. Nie ungetaggte "1.5.x"-Zwischenstände auf Live-Rechnern.

**Warum das wichtig ist:** Manuelle Kopien produzieren still divergierende Zustände zwischen pluginsources, Packagist und den Live-Projekten. Composer sieht die Version nicht, ein `composer install` auf einem anderen Rechner holt einen ganz anderen Stand, und die produzierte `site.min.css` passt zu keinem der Beteiligten. Debugging kostet Stunden ohne dass der Grund erkennbar ist.

### Dev-Loop mit Path-Repository (Symlink)

Für schnelle Iteration ohne Version-Bump pro Test: Ein "Dev-Twin"-Projekt (z.B. `claude`) nutzt Composer Path-Repositories auf `pluginsources/*` mit `symlink: true`. Änderungen in pluginsources greifen sofort — kein `composer update` nötig.

Setup in der `composer.json` des Dev-Twin:
```json
{
  "repositories": [
    {
      "type": "path",
      "url": "/absolute/path/to/pluginsources/*",
      "options": { "symlink": true }
    }
  ]
}
```

Damit path repo greift: das `version`-Feld in jeder pluginsource-`composer.json` muss dem letzten Tag entsprechen (Composer prüft path-repo-Versionen ausschließlich anhand dieses Feldes, nicht der git-Tags).

### Wenn eine Änderung raus soll

1. Commits im pluginsources-Repo — thematisch getrennt (Fix, Feature, Refactor, TODO/Doku).
2. `composer.json` version-Feld bumpen (semver-Patch für Fixes, Minor für neue APIs).
3. Version-Bump als eigenständiger `Version bump`-Commit — bleibt konsistent mit dem übrigen Session-Pattern und erleichtert das Zurückspringen zu einer bestimmten Version.
4. Git-Tag `vX.Y.Z` erzeugen und `origin main + tag` pushen.
5. In den betroffenen Projekten `composer update kirbydesk/<name>` — holt die neue Version über Packagist.

Bei der ersten Version, die eine neue Cross-Plugin-Abhängigkeit einführt (z.B. `pwSnippet`, `pwBlueprint` als neue pagewizard-Helper, die von `kirbyblock-*` genutzt werden), im Commit-Body die minimale kompatible pagewizard-Version nennen — damit ist bei manueller Installation klar, dass beide Ebenen zusammen upgegraded werden müssen.

### Was nie passieren darf

- **`site/plugins/*` in einem Live-Projekt manuell mit einer Datei aus pluginsources überschreiben.** Composer merkt das nicht, das Live-Repo hat aber plötzlich Code, der weder in composer.lock steht noch in einem Release existiert.
- **Ungetaggte Version-Feld-Änderungen pushen.** Wenn `composer.json.version` auf `1.5.6` steht, aber kein Tag `v1.5.6` existiert, holt path-repo (Dev-Twin) die "neue" Version, Packagist aber nicht. Das war die Kern-Ursache der 2026-09-15-Verwirrung.
- **Live-Build-Artefakte (`site.min.css`, `site.min.js`) aus einer nicht-releaseten Version committen.** Wenn dann ein Dev-Rechner die Plugins auf Packagist-Version zurückzieht, produziert `npm run build` andere Ergebnisse als das committete Artefakt.

### Bei ungewissem Zustand

Wenn der Verdacht besteht, dass ein Projekt mit einem nicht-releaseten Snapshot gebaut wurde: `MIGRATION.md` (in jedem Kirbydesk-Projekt vorhanden, bzw. via `scaffold/copy/MIGRATION.md` für neue Projekte) hat eine 5+1-Schritt-Anleitung, die den Zustand wieder auf Packagist-parity bringt. Inklusive Deprecation-Check auf projekt-lokale Legacy-Files.
