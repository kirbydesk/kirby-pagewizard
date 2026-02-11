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
