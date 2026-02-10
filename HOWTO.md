# PageWizard Configuration Guide

## Übersicht

Das PageWizard Plugin verwendet zwei verschiedene Override-Mechanismen, um Default-Werte zu überschreiben:

1. **Farb-Variablen System** (CSS + Config)
2. **Block-Konfiguration System** (Blueprint + Config)

---

## 1. Farb-Variablen Hierarchie

### Die 4 Ebenen (von niedrig zu hoch)

```
1. CSS Global Defaults        (:root in colors.css)
   ↓ überschrieben von
2. CSS Block-Spezifisch        (section[data-block="text"] in colors.css)
   ↓ überschrieben von
3. Config Global               (kirbydesk.pagewizard.colors)
   ↓ überschrieben von
4. Config Block-Spezifisch     (kirbydesk.pagewizard.kirbyblocks.pwText.colors)
```

### Ebene 1: CSS Global Defaults

**Datei:** `src/css/colors.css`

```css
:root {
  --pw-color-primary: #00BBFF;
  --pw-color-secondary: #101828;
  --pw-color-accent: #FF0000;
  --pw-color-background: #FFFFFF;
  --pw-color-text: #101828;
}
```

**Verwendung:** Diese Farben gelten für ALLE Blöcke, wenn nichts anderes definiert ist.

### Ebene 2: CSS Block-Spezifisch

**Datei:** `src/css/colors.css`

```css
/* Text Block */
section[data-block="text"] {
  --pw-color-accent: purple;
}

/* Quote Block */
section[data-block="quote"] {
  --pw-color-accent: blue;
}

/* Media Block */
section[data-block="media"] {
  --pw-color-accent: green;
}
```

**Verwendung:** Überschreibt die globalen CSS-Werte nur für spezifische Block-Typen.

### Ebene 3: Config Global

**Datei:** `site/config/config.php`

```php
'kirbydesk.pagewizard' => [
  'colors' => [
    'primary'    => '#00BBFF',
    'secondary'  => '#101828',
    'accent'     => '#FF6B35',  // Überschreibt #FF0000 aus CSS
    'background' => '#FFFFFF',
    'text'       => '#101828',
  ],
]
```

**Verwendung:** Überschreibt die CSS-Defaults für ALLE Blöcke project-wide.

### Ebene 4: Config Block-Spezifisch

**Datei:** `site/config/config.php`

```php
'kirbydesk.pagewizard' => [
  'colors' => [
    'accent' => '#FF6B35',  // Global: Orange für alle Blöcke
  ],
  'kirbyblocks' => [
    'pwText' => [
      'colors' => [
        'accent' => '#9333EA',  // NUR für Text-Blöcke: Lila
      ]
    ],
    'pwQuote' => [
      'colors' => [
        'accent' => '#10B981',  // NUR für Quote-Blöcke: Grün
      ]
    ]
  ]
]
```

**Verwendung:** Überschreibt die globale Config-Farbe nur für spezifische Block-Typen.

### Wie es technisch funktioniert

**PHP Helper:** `src/helpers/colors.php`

```php
function pwGetColorStyles(string $blockType): string
{
    // 1. Global colors (affect all blocks)
    $globalColors = option('kirbydesk.pagewizard.colors', []);

    // 2. Block-specific colors (only for this block type)
    $blockColors = option("kirbydesk.pagewizard.kirbyblocks.{$blockType}.colors", []);

    // Merge: block-specific overrides global
    $configColors = array_merge($globalColors, $blockColors);

    // Generate inline styles (highest CSS specificity)
    return ' style="--pw-color-primary: #00BBFF; --pw-color-accent: #9333EA;"';
}
```

**Snippet:** `snippets/index.php`

```php
echo '<section';
echo pwGetColorStyles('pwText');  // Generates inline styles
echo '>';
```

**HTML Output:**

```html
<section style="--pw-color-accent: #9333EA;">
  <!-- Inline styles haben höchste Priorität -->
</section>
```

### Vollständiges Beispiel

```php
// config.php
'kirbydesk.pagewizard' => [
  'colors' => [
    'primary'   => '#1E40AF',  // Blau
    'accent'    => '#EF4444',  // Rot (für alle Blöcke)
  ],
  'kirbyblocks' => [
    'pwText' => [
      'colors' => [
        'accent' => '#8B5CF6',  // Lila (nur für Text-Blöcke)
      ]
    ]
  ]
]
```

**Resultierende Farben:**
- **Text-Block:** primary=#1E40AF, accent=#8B5CF6 (Lila)
- **Quote-Block:** primary=#1E40AF, accent=#EF4444 (Rot)
- **Media-Block:** primary=#1E40AF, accent=#EF4444 (Rot)

---

## 2. Block-Konfiguration Hierarchie

### Die 2 Ebenen (von niedrig zu hoch)

```
1. Blueprint Defaults          ($defaults array in blueprints.php)
   ↓ überschrieben von
2. Config Overrides            (kirbydesk.pagewizard.kirbyblocks.pwText)
```

### Ebene 1: Blueprint Defaults

**Datei:** `kirbyblock-text/src/extensions/blueprints.php`

```php
$defaults = [
  'heading'           => true,
  'tagline'           => true,
  'buttons'           => true,
  'text-mode'         => 'textarea',
  'grid'              => true,
  'grid-size-sm'      => 12,
  'grid-size-md'      => 12,
  'grid-size-lg'      => 12,
  'grid-size-xl'      => 12,
  'grid-offset-sm'    => 1,
  'grid-offset-md'    => 1,
  'grid-offset-lg'    => 1,
  'grid-offset-xl'    => 1,
  'spacing'           => true,
  'margin-top'        => false,
  'margin-bottom'     => true,
  'padding-top'       => true,
  'padding-bottom'    => true,
  'theme'             => true,
  'style'             => 'default',
];
```

**Verwendung:** Diese Werte gelten für den Block, wenn nichts in der Config definiert ist.

### Ebene 2: Config Overrides

**Datei:** `site/config/config.php`

```php
'kirbydesk.pagewizard' => [
  'kirbyblocks' => [
    'pwText' => [
      'heading'        => false,         // Überschreibt true → false
      'buttons'        => false,         // Überschreibt true → false
      'text-mode'      => 'writer',      // Überschreibt 'textarea' → 'writer'
      'grid-size-sm'   => 10,            // Überschreibt 12 → 10
      'grid-offset-sm' => 2,             // Überschreibt 1 → 2
      'margin-top'     => true,          // Überschreibt false → true
      // 'tagline' nicht angegeben → bleibt true (aus defaults)
    ]
  ]
]
```

### Wie es technisch funktioniert

**Blueprint:** `kirbyblock-text/src/extensions/blueprints.php`

```php
// 1. Define defaults
$defaults = [
  'heading' => true,
  'buttons' => true,
  'grid-size-sm' => 12,
];

// 2. Read config overrides
$raw = option('kirbydesk.pagewizard.kirbyblocks.pwText', []);

// 3. Merge (config overwrites defaults)
$cfg = array_merge($defaults, is_array($raw) ? $raw : []);

// 4. Use merged config
$defaultHeading = !empty($cfg['heading']);  // false (from config)
$defaultButtons = !empty($cfg['buttons']);  // false (from config)
$gridSizeSm = $cfg['grid-size-sm'];         // 10 (from config)
```

**Wichtig:** Bei `array_merge($defaults, $config)` überschreibt das **zweite** Array das **erste**!

### Vollständiges Beispiel

```php
// config.php - Projekt-spezifische Anpassungen
'kirbydesk.pagewizard' => [
  'kirbyblocks' => [
    'pwText' => [
      // Field visibility
      'heading'        => false,      // Heading-Field deaktivieren
      'tagline'        => true,       // Tagline-Field aktivieren
      'buttons'        => false,      // Buttons-Field deaktivieren

      // Editor settings
      'text-mode'      => 'writer',   // Extended text editor

      // Grid settings
      'grid'           => true,       // Grid-Tab aktivieren
      'grid-size-sm'   => 12,         // Full width on small screens
      'grid-size-md'   => 10,         // 10/12 columns on medium screens
      'grid-size-lg'   => 8,          // 8/12 columns on large screens
      'grid-size-xl'   => 6,          // 6/12 columns on XL screens
      'grid-offset-sm' => 1,          // Start at column 1
      'grid-offset-md' => 2,          // Start at column 2 (centered)
      'grid-offset-lg' => 3,          // Start at column 3 (centered)
      'grid-offset-xl' => 4,          // Start at column 4 (centered)

      // Spacing settings
      'spacing'        => true,       // Spacing-Tab aktivieren
      'margin-top'     => true,       // Top margin enabled
      'margin-bottom'  => true,       // Bottom margin enabled
      'padding-top'    => true,       // Top padding enabled
      'padding-bottom' => true,       // Bottom padding enabled

      // Theme settings
      'theme'          => true,       // Theme-Tab aktivieren
      'style'          => 'variant',  // Use variant style as default

      // Block-specific colors
      'colors' => [
        'accent' => '#9333EA',        // Purple accent for text blocks
      ]
    ]
  ]
]
```

**Resultierende Block-Konfiguration:**
- Heading-Field: **Deaktiviert** (aus Config)
- Tagline-Field: **Aktiviert** (aus Defaults, nicht überschrieben)
- Buttons-Field: **Deaktiviert** (aus Config)
- Text-Mode: **Writer** (aus Config)
- Grid auf MD: **10 Spalten, Start bei 2** (aus Config)
- Accent-Farbe: **#9333EA Lila** (aus Config)

---

## Best Practices

### 1. Wann welche Ebene verwenden?

**CSS Defaults (colors.css):**
- Verwendung: Plugin-Entwicklung
- Zweck: Basis-Farben für alle Installationen
- Änderung: Selten, nur bei Plugin-Updates

**CSS Block-Spezifisch (colors.css):**
- Verwendung: Plugin-Entwicklung
- Zweck: Block-spezifische Farb-Overrides im Plugin
- Änderung: Selten, nur bei Plugin-Updates

**Config Global (config.php):**
- Verwendung: Projekt-Entwicklung
- Zweck: Project-wide Farben für alle Blöcke
- Änderung: Pro Projekt einmalig

**Config Block-Spezifisch (config.php):**
- Verwendung: Projekt-Entwicklung
- Zweck: Spezielle Farben für einzelne Block-Typen
- Änderung: Pro Projekt bei Bedarf

### 2. Empfohlener Workflow

1. **Plugin entwickeln:**
   - Definiere sinnvolle Defaults in `colors.css` und `blueprints.php`
   - Diese Defaults funktionieren out-of-the-box

2. **Projekt aufsetzen:**
   - Überschreibe globale Farben in `config.php` für Brand-Colors
   - Überschreibe Block-Settings in `config.php` für Projekt-Anforderungen

3. **Spezial-Anpassungen:**
   - Überschreibe Block-spezifische Farben nur wenn nötig
   - Überschreibe Block-spezifische Settings nur wenn nötig

### 3. Debugging

**Farben prüfen:**

```php
// In einem Snippet oder Template
$globalColors = option('kirbydesk.pagewizard.colors', []);
$blockColors = option('kirbydesk.pagewizard.kirbyblocks.pwText.colors', []);

dump($globalColors);   // Zeigt globale Config-Farben
dump($blockColors);    // Zeigt block-spezifische Config-Farben
```

**Block-Config prüfen:**

```php
// In blueprints.php während Entwicklung
$raw = option('kirbydesk.pagewizard.kirbyblocks.pwText', []);
dump($raw);           // Zeigt Config-Overrides
dump($cfg);           // Zeigt finale merged Config
```

**Browser DevTools:**

```javascript
// Im Browser Console
const section = document.querySelector('[data-block="text"]');
const styles = getComputedStyle(section);
console.log(styles.getPropertyValue('--pw-color-accent'));
```

---

## Referenz: Verfügbare Farb-Variablen

| Variable | Standard | Verwendung |
|----------|----------|------------|
| `--pw-color-primary` | #00BBFF | Primäre Brand-Farbe |
| `--pw-color-secondary` | #101828 | Sekundäre Brand-Farbe |
| `--pw-color-accent` | #FF0000 | Akzent-Farbe für Highlights |
| `--pw-color-background` | #FFFFFF | Hintergrund-Farbe |
| `--pw-color-text` | #101828 | Text-Farbe |

## Referenz: Verfügbare Block-Settings (pwText)

| Setting | Typ | Standard | Beschreibung |
|---------|-----|----------|--------------|
| `heading` | boolean | true | Heading-Field aktivieren |
| `tagline` | boolean | true | Tagline-Field aktivieren |
| `buttons` | boolean | true | Buttons-Field aktivieren |
| `text-mode` | string | 'textarea' | Editor-Modus: textarea, writer, markdown |
| `grid` | boolean | true | Grid-Tab aktivieren |
| `grid-size-sm` | int | 12 | Grid-Größe SM (1-12) |
| `grid-size-md` | int | 12 | Grid-Größe MD (1-12) |
| `grid-size-lg` | int | 12 | Grid-Größe LG (1-12) |
| `grid-size-xl` | int | 12 | Grid-Größe XL (1-12) |
| `grid-offset-sm` | int | 1 | Grid-Offset SM (1-12) |
| `grid-offset-md` | int | 1 | Grid-Offset MD (1-12) |
| `grid-offset-lg` | int | 1 | Grid-Offset LG (1-12) |
| `grid-offset-xl` | int | 1 | Grid-Offset XL (1-12) |
| `spacing` | boolean | true | Spacing-Tab aktivieren |
| `margin-top` | boolean | false | Top-Margin aktivieren |
| `margin-bottom` | boolean | true | Bottom-Margin aktivieren |
| `padding-top` | boolean | true | Top-Padding aktivieren |
| `padding-bottom` | boolean | true | Bottom-Padding aktivieren |
| `theme` | boolean | true | Theme-Tab aktivieren |
| `style` | string | 'default' | Style: default, variant |
| `colors` | array | [] | Block-spezifische Farben |
