# Icon Sets

Hier liegen die SVG-Quelldateien für den `pwicon`-Feldtyp.

## Verzeichnisstruktur

```
assets/
  src/
    remix/      ← Quelldateien Remix Icons
    custom/     ← eigene/projektspezifische Icons
    meinset/    ← beliebige weitere Sets
  icons/
    remix.svg   ← generiertes Sprite (nicht manuell bearbeiten)
    custom.svg
    meinset.svg
```

## Neues Set erstellen

1. Unterordner anlegen: `assets/src/meinset/`
2. SVG-Dateien hineinkopieren (Unterordner erlaubt)
3. Sprite generieren:

```bash
node assets/src/build-sprite.js --set meinset
```

Der Dateiname (ohne `.svg`) wird zur Icon-ID im Picker.

## Set aktivieren

In `site/config/pagewizard.php`:

```php
return [
    'icon-set' => 'meinset',
    // ...
];
```

Ohne diese Angabe greift der Plugin-Default `remix`.

## Custom Icons (Ergänzung zum aktiven Set)

Icons in `assets/src/custom/` werden **immer** zusätzlich zum aktiven Set geladen und im Picker oben angezeigt (gestrichelte Border).

```bash
node build-sprite.js --set custom
```

## Vorhandene Sets neu bauen

```bash
node assets/src/build-sprite.js --set remix
node assets/src/build-sprite.js --set custom
```

## Hinweise

- Unterstützte Formate: Standard-SVG mit `viewBox`-Attribut
- Unterordner im Quellverzeichnis werden rekursiv durchsucht
- Icons werden alphabetisch sortiert
- Bei doppelten Dateinamen gewinnt das zuletzt einsortierte (alphabetisch)
