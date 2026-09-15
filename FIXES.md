# Fixes

## ✅ `pwConfig::tailwindSetup()` — Block-Vars gehen bei Multi-Request-Renderings verloren

**Behoben am 2026-09-15.**

**Symptom**
`storage/temp/vars.css` enthielt nach dem Rendering **keine per-Block-CSS-Vars** (`--pw<block>-*`), obwohl:
- `pwConfig::registered()` alle Blocks korrekt lieferte
- `settings.json > values.items.vars/colors` sauber gepflegt war
- Ein CLI-Test von `pwConfig::tailwindSetup()` die Vars korrekt generierte

Konsequenz: `site.min.css` enthielt `var(--pwcardlets-item-heading-text)` etc. als Referenz, aber die zugehörige `--pwcardlets-item-*: value`-Definition fehlte. CSS-Fallback griff (transparent/0). Cardlet-Items hatten dann keine Farbe, kein Padding, keinen Border.

**Ursache**
Der `route:after`-Hook aus `projectbuilder.php` läuft in Kirby **mehrmals pro Request**, wenn Kirby intern Sub-Requests macht (Language-Redirect `/` → `/de`, Trailing-Slash, Password-Protection, etc.). Bei jedem Hook-Aufruf iterierte der Hook alle Plugins mit `.stub`-Marker und rief `pwConfig::tailwindSetup($pluginDir, $imports)` auf.

Der Guard `private static bool $blockValuesGenerated` sollte innerhalb einer Iteration verhindern, dass die Block-Vars-Loop für jedes der ~10 Plugins wiederholt läuft:

```php
if (!self::$blockValuesGenerated) {
    self::$blockValuesGenerated = true;
    // Block-Values-Loop
    $imports[] = ":root {\n$blockValueLines\n}";
}
```

Die Static-Property überlebte aber zwischen den Hook-Aufrufen desselben Requests. Beim ersten Hook-Aufruf wurde `$blockValuesGenerated=true` gesetzt und die Block-Vars-`:root {}` zu `$imports` hinzugefügt. Das `$imports`-Array war lokal zum Hook-Aufruf. Beim zweiten Hook-Aufruf war `$imports` ein frisches Array, aber der Guard blockte die Regeneration → Block-Vars fehlten.

Am Ende des Hook-Aufrufs wurde `vars.css` neu geschrieben. Der zweite Aufruf überschrieb die Version des ersten mit einer Version **ohne** Block-Vars.

**Fix**
Guard komplett entfernt. Duplication innerhalb eines Hook-Aufrufs (Block-Vars 1× pro Plugin = ~10× im `$imports`-Array) ist harmlos, weil Tailwinds Build-Prozess identische `:root {...}`-Deklarationen konsolidiert / der spätere Block gewinnt bei gleichen Selektoren.

Die Property `$blockValuesGenerated` ist ebenfalls aus dem Class-Level entfernt.

**Alternative Fixes die verworfen wurden**
- Reset-Guard über Reflection (`ReflectionProperty->setValue(null, false)`) im projectbuilder.php: funktioniert, ist aber projekt-spezifisch und muss in jedem projectbuilder.php-Scaffold ergänzt werden. `->setAccessible()` ist zudem in PHP 8.5 deprecated.
- Guard pro `$imports`-Hash tracken: PHP-Arrays haben keine Identity, Hash-Berechnung wäre teuer und unschön.
- Direkter Aufruf der Language-URL um Redirects zu vermeiden: funktioniert nicht — der Hook wird von Kirby trotzdem mehrfach getriggert.

**Gefunden bei**
- Debugging von claude als rh-Zwilling (Multi-Language DE), 2026-09-15
- Betraf alle Multi-Language-Projekte und Projekte mit Redirects/Sub-Requests im Response-Flow
- Alle installierten `--pw<blockType>-*`-Vars waren betroffen
