# Göteborg DokuWiki Template

En modern, responsiv DokuWiki-mall baserad på Bootstrap 5, som följer Göteborgs Stads grafiska profil och styleguide.

## Funktioner

- Responsiv design med stöd för alla skärmstorlekar
- Följer Göteborgs Stads grafiska profil (färger, typsnitt, etc.)
- Byggd på Bootstrap 5 för moderna komponenter och layout
- Stöd för både Dark Mode och Light Mode
- Växla enkelt mellan dark/light mode med hjälp av en switch
- Konfigurerbara inställningar via DokuWiki Configuration Manager
- Sidospalt som kan placeras till vänster eller höger
- Anpassningsbar sidfot
- Söker automatiskt efter systemets färglägesinställningar (om aktiverat)
- Optimerad för bästa läsbarhet och tillgänglighet
- Helt responsiv på mobila enheter
- Stöd för alla standardfunktioner i DokuWiki

## Installation

1. Ladda ner ZIP-filen med templaten
2. Packa upp filerna i `lib/tpl/goteborg` i din DokuWiki-installation
3. Gå till Admin -> Konfigurationshanteraren och välj "goteborg" som aktiv mall
4. Anpassa inställningarna efter behov

## Konfiguration

Templaten erbjuder ett flertal konfigurationsalternativ:

- **sidebar_position**: Placering av sidomeny (vänster eller höger)
- **sidebar_size**: Bredd på sidomeny (i kolumner, t.ex. 2 för Bootstrap grid)
- **navbar_position**: Navbar position (top eller bottom)
- **dark_mode_default**: Aktivera mörkt läge som standard
- **auto_dark_mode**: Följ systeminställningar för mörkt/ljust läge
- **show_tools**: Visa verktyg i navigeringen
- **fluid_layout**: Använd fullbredds-layout (fluid) istället för centrerad container
- **custom_css**: URL eller filsökväg till anpassad CSS-fil
- **custom_js**: URL eller filsökväg till anpassad JavaScript-fil

och många fler alternativ som finns beskrivna i konfigurationshanteraren.

## Färger och stilar

Templaten använder Göteborgs Stads officiella färgpalett:

- Göteborgsblå: #004b93 (primärfärg)
- Mörkblå: #003359
- Ljusblå: #009eb4
- Grön: #00753b
- Lila: #712082
- Röd: #c31c55
- Orange: #d85512

Dessa färger används konsekvent genom hela templaten och anpassas automatiskt i dark mode.

## Anpassning

### Sidomeny

Skapa eller redigera sidan med namnet specificerat i `$conf['sidebar']` (standard är "sidebar") för att anpassa sidomeny.

### Sidfot

Anpassa sidfoten genom att ändra inställningarna `footer_content` och `footer_links` i konfigurationshanteraren.

### Ytterligare anpassningar

För mer avancerade anpassningar, kan du skapa följande filer:

- `lib/tpl/goteborg/user/style.css` - Anpassad CSS
- `lib/tpl/goteborg/user/script.js` - Anpassad JavaScript

Dessa filer kommer automatiskt att laddas om de finns.

## Systemkrav

- DokuWiki 2020-07-29 "Hogfather" eller senare
- PHP 7.2 eller senare
- Moderna webbläsare som stöder CSS Custom Properties (IE11 stöds ej)

## Licens

GPL 2.0 eller senare (samma som DokuWiki)