<?php

/**
 * @author Marwan Al-Soltany <MarwanAlsoltany@gmail.com>
 * @copyright Marwan Al-Soltany 2022
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MAKS\Mighty\Validation\Pattern;

/**
 * Holder for a collection o f regular expressions.
 *
 * @package Mighty\Validator
 */
final class Regex
{
    // ---------------------
    // PHP Patterns.
    // ---------------------
    public const PHP_KEYWORD        = self::PATTERNS['php.keyword'];
    public const PHP_RESERVED       = self::PATTERNS['php.reserved'];
    public const PHP_RESERVED_EXTRA = self::PATTERNS['php.reserved.extra'];
    // ---------------------


    // ---------------------
    // Language/Country Patterns.
    // ---------------------
    public const LANGUAGE_ALPHA2 = self::PATTERNS['language.alpha2'];
    public const LANGUAGE_ALPHA3 = self::PATTERNS['language.alpha3'];
    public const COUNTRY_ALPHA2  = self::PATTERNS['country.alpha2'];
    public const COUNTRY_ALPHA3  = self::PATTERNS['country.alpha3'];
    public const COUNTRY_NUM     = self::PATTERNS['country.num'];
    // ---------------------


    // ---------------------
    // DateTime Patterns.
    // ---------------------
    public const DATETIME_FORMAT_GLOBAL = self::PATTERNS['datetime.format.global'];
    public const DATETIME_FORMAT_LOCAL  = self::PATTERNS['datetime.format.local'];
    public const DATESTAMP              = self::PATTERNS['datestamp'];
    public const DATESTAMP_DMY          = self::PATTERNS['datestamp.dmy'];
    public const DATESTAMP_MDY          = self::PATTERNS['datestamp.mdy'];
    public const DATESTAMP_YMD          = self::PATTERNS['datestamp.ymd'];
    public const TIMESTAMP              = self::PATTERNS['timestamp'];
    public const TIMESTAMP_12           = self::PATTERNS['timestamp.12'];
    public const TIMESTAMP_HMS          = self::PATTERNS['timestamp.hms'];
    public const TIMESTAMP_HM           = self::PATTERNS['timestamp.hm'];
    public const TIMESTAMP_MS           = self::PATTERNS['timestamp.ms'];
    public const CALENDER_DAY           = self::PATTERNS['calender.day'];
    public const CALENDER_MONTH         = self::PATTERNS['calender.month'];
    // ---------------------


    // ---------------------
    // Account Patterns.
    // ---------------------
    public const USERNAME = self::PATTERNS['username'];
    public const PASSWORD = self::PATTERNS['password'];
    // ---------------------


    // ---------------------
    // Common Patterns.
    // ---------------------
    public const BOOLEAN       = self::PATTERNS['boolean'];
    public const BOOLEAN_TRUE  = self::PATTERNS['boolean.true'];
    public const BOOLEAN_FALSE = self::PATTERNS['boolean.false'];
    public const UUID          = self::PATTERNS['uuid'];
    public const UUID_V1       = self::PATTERNS['uuid.v1'];
    public const UUID_V2       = self::PATTERNS['uuid.v2'];
    public const UUID_V3       = self::PATTERNS['uuid.v3'];
    public const UUID_V4       = self::PATTERNS['uuid.v4'];
    public const UUID_V5       = self::PATTERNS['uuid.v5'];
    public const ASCII         = self::PATTERNS['ascii'];
    public const SLUG          = self::PATTERNS['slug'];
    public const META          = self::PATTERNS['meta'];
    public const TEXT          = self::PATTERNS['text'];
    public const WORDS         = self::PATTERNS['words'];
    public const SPACELESS     = self::PATTERNS['spaceless'];
    public const EMOJI         = self::PATTERNS['emoji'];
    public const ROMAN         = self::PATTERNS['roman'];
    public const PHONE         = self::PATTERNS['phone'];
    public const GEOLOCATION   = self::PATTERNS['geolocation'];
    // ---------------------


    // ---------------------
    // Version Patterns.
    // ---------------------
    public const VERSION         = self::PATTERNS['version'];
    public const VERSION_CAPTURE = self::PATTERNS['version.capture'];
    // ---------------------


    // ---------------------
    // Amount Patterns.
    // ---------------------
    public const AMOUNT        = self::PATTERNS['amount'];
    public const AMOUNT_DOLLAR = self::PATTERNS['amount.dollar'];
    public const AMOUNT_EURO   = self::PATTERNS['amount.euro'];
    // ---------------------


    // ---------------------
    // CSS Color Patterns.
    // ---------------------
    public const COLOR           = self::PATTERNS['color'];
    public const COLOR_HEX       = self::PATTERNS['color.hex'];
    public const COLOR_HEX_SHORT = self::PATTERNS['color.hexShort'];
    public const COLOR_HEX_LONG  = self::PATTERNS['color.hexLong'];
    public const COLOR_HEX_ALPHA = self::PATTERNS['color.hexAlpha'];
    public const COLOR_RGB       = self::PATTERNS['color.rgb'];
    public const COLOR_RGBA      = self::PATTERNS['color.rgba'];
    public const COLOR_RGB_NEW   = self::PATTERNS['color.rgb.new'];
    public const COLOR_HSL       = self::PATTERNS['color.hsl'];
    public const COLOR_HSLA      = self::PATTERNS['color.hsla'];
    public const COLOR_HSL_NEW   = self::PATTERNS['color.hsl.new'];
    public const COLOR_KEYWORD   = self::PATTERNS['color.keyword'];
    // ---------------------


    // ---------------------
    // Identifiers Patterns.
    // ---------------------
    public const SSN         = self::PATTERNS['ssn'];
    public const SIN         = self::PATTERNS['sin'];
    public const NINO        = self::PATTERNS['nino'];
    public const VIN         = self::PATTERNS['vin'];
    public const VIN_CAPTURE = self::PATTERNS['vin'];
    public const ISSN        = self::PATTERNS['issn'];
    public const ISIN        = self::PATTERNS['isin'];
    public const ISBN        = self::PATTERNS['isbn'];
    public const ISBN_10     = self::PATTERNS['isbn.10'];
    public const ISBN_13     = self::PATTERNS['isbn.13'];
    public const IMEI        = self::PATTERNS['imei'];
    public const IMEI_SV     = self::PATTERNS['imei.sv'];
    public const MEID        = self::PATTERNS['meid'];
    public const ESN         = self::PATTERNS['esn'];
    // ---------------------


    // ---------------------
    // Financial Patterns.
    // ---------------------
    public const CURRENCY_ALPHA              = self::PATTERNS['currency.alpha'];
    public const CURRENCY_NUM                = self::PATTERNS['currency.num'];
    public const CURRENCY_NAME               = self::PATTERNS['currency.name'];
    public const CREDITCARD                  = self::PATTERNS['creditcard'];
    public const CREDITCARD_VISA             = self::PATTERNS['creditcard.visa'];
    public const CREDITCARD_MASTERCARD       = self::PATTERNS['creditcard.mastercard'];
    public const CREDITCARD_DISCOVER         = self::PATTERNS['creditcard.discover'];
    public const CREDITCARD_AMERICAN_EXPRESS = self::PATTERNS['creditcard.americanExpress'];
    public const CREDITCARD_DINERS_CLUB      = self::PATTERNS['creditcard.dinersClub'];
    public const CREDITCARD_JCB              = self::PATTERNS['creditcard.jcb'];
    public const CREDITCARD_MAESTRO          = self::PATTERNS['creditcard.maestro'];
    public const CREDITCARD_CHINA_UNIONPAY   = self::PATTERNS['creditcard.chinaUnionPay'];
    public const CREDITCARD_INSTAPAYMENT     = self::PATTERNS['creditcard.instaPayment'];
    public const CREDITCARD_LASER            = self::PATTERNS['creditcard.laser'];
    public const CREDITCARD_UATP             = self::PATTERNS['creditcard.uatp'];
    public const CREDITCARD_MIR              = self::PATTERNS['creditcard.mir'];
    public const CVV                         = self::PATTERNS['cvv'];
    public const BIC                         = self::PATTERNS['bic'];
    public const IBAN                        = self::PATTERNS['iban'];
    public const IBAN_AD                     = self::PATTERNS['iban.ad'];
    public const IBAN_AE                     = self::PATTERNS['iban.ae'];
    public const IBAN_AL                     = self::PATTERNS['iban.al'];
    public const IBAN_AT                     = self::PATTERNS['iban.at'];
    public const IBAN_AZ                     = self::PATTERNS['iban.az'];
    public const IBAN_BA                     = self::PATTERNS['iban.ba'];
    public const IBAN_BE                     = self::PATTERNS['iban.be'];
    public const IBAN_BG                     = self::PATTERNS['iban.bg'];
    public const IBAN_BH                     = self::PATTERNS['iban.bh'];
    public const IBAN_BR                     = self::PATTERNS['iban.br'];
    public const IBAN_BY                     = self::PATTERNS['iban.by'];
    public const IBAN_CH                     = self::PATTERNS['iban.ch'];
    public const IBAN_CR                     = self::PATTERNS['iban.cr'];
    public const IBAN_CY                     = self::PATTERNS['iban.cy'];
    public const IBAN_CZ                     = self::PATTERNS['iban.cz'];
    public const IBAN_DE                     = self::PATTERNS['iban.de'];
    public const IBAN_DK                     = self::PATTERNS['iban.dk'];
    public const IBAN_DO                     = self::PATTERNS['iban.do'];
    public const IBAN_EE                     = self::PATTERNS['iban.ee'];
    public const IBAN_EG                     = self::PATTERNS['iban.eg'];
    public const IBAN_ES                     = self::PATTERNS['iban.es'];
    public const IBAN_FI                     = self::PATTERNS['iban.fi'];
    public const IBAN_FO                     = self::PATTERNS['iban.fo'];
    public const IBAN_FR                     = self::PATTERNS['iban.fr'];
    public const IBAN_GB                     = self::PATTERNS['iban.gb'];
    public const IBAN_GE                     = self::PATTERNS['iban.ge'];
    public const IBAN_GI                     = self::PATTERNS['iban.gi'];
    public const IBAN_GL                     = self::PATTERNS['iban.gl'];
    public const IBAN_GR                     = self::PATTERNS['iban.gr'];
    public const IBAN_GT                     = self::PATTERNS['iban.gt'];
    public const IBAN_HR                     = self::PATTERNS['iban.hr'];
    public const IBAN_HU                     = self::PATTERNS['iban.hu'];
    public const IBAN_IE                     = self::PATTERNS['iban.ie'];
    public const IBAN_IL                     = self::PATTERNS['iban.il'];
    public const IBAN_IQ                     = self::PATTERNS['iban.iq'];
    public const IBAN_IS                     = self::PATTERNS['iban.is'];
    public const IBAN_IT                     = self::PATTERNS['iban.it'];
    public const IBAN_JO                     = self::PATTERNS['iban.jo'];
    public const IBAN_KW                     = self::PATTERNS['iban.kw'];
    public const IBAN_KZ                     = self::PATTERNS['iban.kz'];
    public const IBAN_LB                     = self::PATTERNS['iban.lb'];
    public const IBAN_LC                     = self::PATTERNS['iban.lc'];
    public const IBAN_LI                     = self::PATTERNS['iban.li'];
    public const IBAN_LT                     = self::PATTERNS['iban.lt'];
    public const IBAN_LU                     = self::PATTERNS['iban.lu'];
    public const IBAN_LV                     = self::PATTERNS['iban.lv'];
    public const IBAN_LY                     = self::PATTERNS['iban.ly'];
    public const IBAN_MC                     = self::PATTERNS['iban.mc'];
    public const IBAN_MD                     = self::PATTERNS['iban.md'];
    public const IBAN_ME                     = self::PATTERNS['iban.me'];
    public const IBAN_MK                     = self::PATTERNS['iban.mk'];
    public const IBAN_MR                     = self::PATTERNS['iban.mr'];
    public const IBAN_MT                     = self::PATTERNS['iban.mt'];
    public const IBAN_MU                     = self::PATTERNS['iban.mu'];
    public const IBAN_NL                     = self::PATTERNS['iban.nl'];
    public const IBAN_NO                     = self::PATTERNS['iban.no'];
    public const IBAN_PK                     = self::PATTERNS['iban.pk'];
    public const IBAN_PL                     = self::PATTERNS['iban.pl'];
    public const IBAN_PS                     = self::PATTERNS['iban.ps'];
    public const IBAN_PT                     = self::PATTERNS['iban.pt'];
    public const IBAN_QA                     = self::PATTERNS['iban.qa'];
    public const IBAN_RO                     = self::PATTERNS['iban.ro'];
    public const IBAN_RS                     = self::PATTERNS['iban.rs'];
    public const IBAN_SA                     = self::PATTERNS['iban.sa'];
    public const IBAN_SC                     = self::PATTERNS['iban.sc'];
    public const IBAN_SD                     = self::PATTERNS['iban.sd'];
    public const IBAN_SE                     = self::PATTERNS['iban.se'];
    public const IBAN_SI                     = self::PATTERNS['iban.si'];
    public const IBAN_SK                     = self::PATTERNS['iban.sk'];
    public const IBAN_SM                     = self::PATTERNS['iban.sm'];
    public const IBAN_ST                     = self::PATTERNS['iban.st'];
    public const IBAN_SV                     = self::PATTERNS['iban.sv'];
    public const IBAN_TL                     = self::PATTERNS['iban.tl'];
    public const IBAN_TN                     = self::PATTERNS['iban.tn'];
    public const IBAN_TR                     = self::PATTERNS['iban.tr'];
    public const IBAN_UA                     = self::PATTERNS['iban.ua'];
    public const IBAN_VA                     = self::PATTERNS['iban.va'];
    public const IBAN_VG                     = self::PATTERNS['iban.vg'];
    public const IBAN_XK                     = self::PATTERNS['iban.xk'];
    // ---------------------


    /**
     * REGEX Patterns.
     *
     * @var array<string,string>
     */
    public const PATTERNS = [
        // php keywords pattern
        // https://www.php.net/manual/en/reserved.keywords.php#111941
        'php.keyword'        => '/\b(?:a(?:bstract|nd|rray|s)|break|c(?:a(?:llable|se|tch)|l(?:ass|one)|on(?:st|tinue))|d(?:e(?:clare|fault)|ie|o)|e(?:cho|lse(?:if)?|mpty|nd(?:declare|for(?:each)?|if|switch|while)|val|x(?:it|tends))|f(?:inal(?:ly)?|n|or(?:each)?|unction)|g(?:lobal|oto)|i(?:f|mplements|n(?:clude(?:_once)?|st(?:anceof|eadof)|terface)|sset)|list|match|n(?:amespace|ew)|or|p(?:r(?:i(?:nt|vate)|otected)|ublic)|re(?:adonly|quire(?:_once)?|turn)|s(?:tatic|witch)|t(?:hrow|r(?:ait|y))|u(?:nset|se)|var|while|xor|yield(?:[ ]+from)?|__halt_compiler)\b/i',
        // php reserved words pattern
        // https://www.php.net/manual/en/reserved.other-reserved-words.php
        'php.reserved'       => '/\b(?:a(?:bstract|nd|rray|s)|b(?:ool|reak)|c(?:a(?:llable|se|tch)|l(?:ass|one)|on(?:st|tinue))|d(?:e(?:clare|fault)|ie|o)|e(?:cho|lse(?:if)?|mpty|nd(?:declare|for(?:each)?|if|switch|while)|val|x(?:it|tends))|f(?:alse|inal(?:ly)?|loat|n|or(?:each)?|unction)|g(?:lobal|oto)|i(?:f|mplements|n(?:clude(?:_once)?|st(?:anceof|eadof)|t(?:erface)?)|sset|terable)|list|m(?:atch|ixed)|n(?:amespace|e(?:ver|w)|ull)|o(?:bject|r)|p(?:r(?:i(?:nt|vate)|otected)|ublic)|re(?:adonly|quire(?:_once)?|turn)|s(?:t(?:atic|ring)|witch)|t(?:hrow|r(?:ait|ue|y))|u(?:nset|se)|v(?:ar|oid)|while|xor|yield(?:[ ]+from)?|__(?:halt_compiler|(?:CLASS|DIR|FILE|FUNCTION|LINE|METHOD|NAMESPACE|TRAIT)__))\b/i',
        // php reserved words with soft reserved words pattern
        // https://www.php.net/manual/en/reserved.other-reserved-words.php
        'php.reserved.extra' => '/\b(?:a(?:bstract|nd|rray|s)|b(?:ool|reak)|c(?:a(?:llable|se|tch)|l(?:ass|one)|on(?:st|tinue))|d(?:e(?:clare|fault)|ie|o)|e(?:cho|lse(?:if)?|mpty|n(?:d(?:declare|for(?:each)?|if|switch|while)|um)|val|x(?:it|tends))|f(?:alse|inal(?:ly)?|loat|n|or(?:each)?|unction)|g(?:lobal|oto)|i(?:f|mplements|n(?:clude(?:_once)?|st(?:anceof|eadof)|t(?:erface)?)|sset|terable)|list|m(?:atch|ixed)|n(?:amespace|e(?:ver|w)|u(?:ll|meric))|o(?:bject|r)|p(?:r(?:i(?:nt|vate)|otected)|ublic)|re(?:adonly|quire(?:_once)?|source|turn)|s(?:t(?:atic|ring)|witch)|t(?:hrow|r(?:ait|ue|y))|u(?:nset|se)|v(?:ar|oid)|while|xor|yield(?:[ ]+from)?|__(?:halt_compiler|(?:CLASS|DIR|FILE|FUNCTION|LINE|METHOD|NAMESPACE|TRAIT)__))\b/i',

        // language ISO 639-1 2-letter code pattern
        'language.alpha2' => '/^(?:a[bafkmrnsveyz]|s[qemgacrndiklotuwsv]|h[yrtaeziou]|b[maenisrgo]|e[unotels]|m[ykgsltirhn]|c[aheuvorsy]|n[ylavdrgeobn]|z[hau]|k[walnrskmiyvgoju]|d[avze]|f[ojiryfa]|g[dlnuav]|l[goavintub]|i[sogdaeukti]|j[av]|r[womnu]|o[cjrms]|p[islta]|qu|t[lygatehiosnrkw]|u[gkrz]|v[eio]|w[ao]|xh|y[io])$/i',
        // language ISO 639-2/T 3-letter code pattern
        'language.alpha3' => '/^(?:a(?:bk|ar|fr|ka|mh|r[ag]|sm|v[ae]|ym|ze)|s(?:qi|m[eo]|a[gn]|r[dp]|n[ad]|in|l[kv]|o[mt]|pa|un|w[ae]|sw)|h(?:ye|rv|a[tu]|e[br]|in|mo|un)|b(?:a[mk]|e[ln]|is|o[sd]|re|ul)|e(?:us|ng|po|st|we|ll)|m(?:ya|kd|l[gt]|sa|a[lrh]|ri|on)|c(?:at|h[aeuv]|o[rs]|re|es|ym)|n(?:ya|ld|a[uv]|d[eo]|bl|ep|o[rb]|no)|z(?:h[oa]|ul)|d(?:an|iv|zo|eu)|f(?:a[os]|i[jn]|r[ay]|ul)|g(?:l[agev]|rn|uj)|l(?:u[gb]|a[otv]|i[mnt]|tz)|k(?:a[tlnusz]|hm|i[knr]|o[mnr]|u[ar])|i(?:sl|do|bo|n[da]|le|ku|pk|ta|ii)|j(?:pn|av)|o(?:ci|ji|r[im]|ss)|p(?:li|us|o[lr]|an)|que|r(?:o[nh]|u[ns])|t(?:g[lk]|a[hmt]|el|ha|ir|on|s[on]|u[rk]|wi)|u(?:ig|kr|rd|zb)|v(?:en|ie|ol)|w(?:ln|ol)|xho|y(?:id|or))$/i',
        // country ISO 3166-1 alpha-2 2-letter code pattern
        'country.alpha2'  => '/^(?:A[FXLSDOIQGRMWUTZE]|D[ZKJMOE]|B[SHDBYEZJMTOQAWVRNGFIL]|I[OSNDRQEMLT]|C[VMAFLNXCOGDKRIUWYZH]|K[HYMZEIPRWGN]|T[DFWJZHLGKOTNRMCV]|H[RTMNKU]|E[CGRETSH]|S[VZHMTANCLGXKIBOSDRJEY]|G[QFAMEHIRLDPUTGNWYSB]|F[KOJIRM]|P[FKWSAGYEHNLTRM]|V[ACUENGI]|J[MPEO]|L[AVBSRYITUCK]|M[OGWYVLTHQRUXDCNESAZMKPF]|Y[TE]|N[ARPLCZIEGUFO]|OM|QA|R[EOUWS]|W[SF]|Z[AMW]|U[GASMYZ])$/i',
        // country ISO 3166-1 alpha-3 3-letter code pattern
        'country.alpha3'  => '/^(?:A(?:FG|L[AB]|SM|ND|GO|IA|T[AGF]|R[GME]|BW|U[ST]|ZE)|D(?:ZA|NK|JI|MA|OM|EU)|B(?:H[SR]|G[DR]|R[BAN]|L[RZM]|E[LNS]|MU|TN|OL|IH|WA|VT|FA|DI)|I(?:OT|S[LR]|ND|DN|R[NQL]|MN|TA)|C(?:PV|MR|A[NF]|Y[MP]|H[LNE]|XR|CK|O[LMGDK]|RI|IV|U[BW]|ZE)|K(?:HM|AZ|EN|IR|OR|WT|GZ|NA)|T(?:C[DA]|WN|JK|ZA|HA|LS|GO|K[LM]|ON|TO|U[NRV])|H(?:RV|TI|MD|ND|KG|UN)|E(?:CU|GY|RI|S[TPH]|TH)|S(?:L[VEB]|W[ZE]|HN|PM|MR|TP|AU|EN|RB|Y[CR]|G[PS]|XM|V[KN]|OM|SD|DN|UR|JM)|G(?:N[QB]|U[FMY]|AB|MB|EO|HA|I[BN]|R[CLD]|LP|TM|GY|BR)|F(?:LK|R[OA]|JI|IN|SM)|P(?:YF|R[KYTI]|A[KN]|LW|SE|NG|ER|HL|CN|OL)|V(?:AT|CT|UT|EN|NM|GB|IR)|J(?:AM|PN|EY|OR)|L(?:AO|VA|B[NRY]|SO|IE|TU|UX|CA|KA)|M(?:A[CRF]|D[GVA]|WI|Y[ST]|L[IT]|HL|TQ|RT|US|EX|CO|N[GEP]|SR|OZ|MR|KD)|N(?:AM|RU|PL|LD|CL|ZL|I[CU]|ER|GA|FK|OR)|OMN|QAT|R(?:EU|OU|US|WA)|W(?:SM|LF)|Z(?:AF|MB|WE)|U(?:GA|KR|SA|MI|RY|ZB)|YEM)$/i',
        // country ISO 3166-1 numeric code pattern
        'country.num'     => '/^(?:0(?:0[48]|1[026]|2[048]|3[126]|4[048]|5[0126]|6[048]|7[0246]|8[46]|9[026])|1(?:0[048]|1[26]|2[04]|3[26]|4[048]|5[268]|6[26]|7[0458]|8[048]|9[126])|2(?:0[348]|1[248]|2[26]|3[123489]|4[268]|5[048]|6[0268]|7[056]|88|9[26])|3(?:0[048]|1[26]|2[048]|3[246]|4[048]|5[26]|6[048]|7[26]|8[048]|9[28])|4(?:0[048]|1[0478]|2[268]|3[048]|4[026]|5[048]|6[26]|7[048]|8[04]|9[2689])|5(?:0[048]|1[26]|2[048]|3[1345]|4[08]|5[48]|6[26]|7[048]|8[013456]|9[18])|6(?:0[048]|1[26]|2[046]|3[048]|4[236]|5[249]|6[0236]|7[048]|8[268]|9[04])|7(?:0[23456]|1[06]|2[489]|32|4[048]|5[26]|6[0248]|7[26]|8[048]|9[2568])|8(?:0[047]|18|26|3[1234]|40|5[048]|6[02]|76|8[27]|94))$/i',

        // datetime format global pattern: value must be as defined in the HTML5 specification
        'datetime.format.global' => '/^(\d{4,})-(\d{2})-(\d{2})[T ](\d{2}):(\d{2})(?::(\d{2}(?:\.\d+)?))?(Z|[+-]\d{2}:?\d{2})$/',
        // datetime format local pattern: value must be as defined in the HTML5 specification
        'datetime.format.local'  => '/^(\d{4,})-(\d{2})-(\d{2})[T ](\d{2}):(\d{2})(?::(\d{2}(?:\.\d+)?))?$/',
        // datestamp pattern: (dd/mm/yyyy or dd-mm-yyyy or dd.mm.yyyy) or (mm/dd/yyyy or mm-dd-yyyy or mm.dd.yyyy) or
        'datestamp'              => '/^(?:(?:(?:0?[1-9]|[1-2][0-9]|3[0-1])([-\/\.])(?:0?[1-9]|[0-1][0-2])\1(?:\d{4}))|(?:(?:0?[1-9]|[0-1][0-2])([-\/\.])(?:0?[1-9]|[1-2][0-9]|3[0-1])\2(?:\d{4})))$/',
        // datestamp DMY pattern: (dd/mm/yyyy or dd-mm-yyyy or dd.mm.yyyy)
        'datestamp.dmy'          => '/^(?:(?:0?[1-9]|[1-2][0-9]|3[0-1])([-\/\.])(?:0?[1-9]|[0-1][0-2])\1(?:\d{4}))$/',
        // datestamp MDY pattern: (mm/dd/yyyy or mm-dd-yyyy or mm.dd.yyyy)
        'datestamp.mdy'          => '/^(?:(?:0?[1-9]|[0-1][0-2])([-\/\.])(?:0?[1-9]|[1-2][0-9]|3[0-1])\1(?:\d{4}))$/',
        // datestamp YMD pattern: (yyyy/mm/dd or yyyy-mm-dd or yyyy.mm.dd)
        'datestamp.ymd'          => '/^(?:(?:[0-9]{4})([-\/\.])(?:0?[1-9]|[0-1][0-2])\1(?:0?[1-9]|[1-2][0-9]|3[0-1]))$/',
        // timestamp pattern: (hh:mm:ss or hh:mm)
        'timestamp'              => '/^(?:(?:[0-2][0-3]|[0-1][0-9]|[0-9]):(?:[0-5]{0,1}[0-9])(?::[0-5]{0,1}[0-9])?)$/',
        // timestamp 12-hour pattern: (hh:mm:ss or hh:mm)
        'timestamp.12'           => '/^(?:(?:12|11|10|0?[0-9]):(?:[0-5]{0,1}[0-9])(?::[0-5]{0,1}[0-9])?(?:\s*[AP]M)?)$/',
        // timestamp HMS pattern: (hh:mm:ss)
        'timestamp.hms'          => '/^(?:(?:[0-2][0-3]|[0-1][0-9]|[0-9]):(?:[0-5]{0,1}[0-9]):(?:[0-5]{0,1}[0-9]))$/',
        // timestamp HM pattern: (hh:mm)
        'timestamp.hm'           => '/^(?:(?:[0-2][0-3]|[0-1][0-9]|[0-9]):(?:[0-5]{0,1}[0-9]))$/',
        // timestamp MS pattern: (mm:ss)
        'timestamp.ms'           => '/^(?:(?:[0-5]{0,1}[0-9]):(?:[0-5]{0,1}[0-9]))$/',
        // weekday pattern: (short or long)
        'calender.day'           => '/^(?:Sun(?:day)?|Mon(?:day)?|Tue(?:sday)?|Wed(?:nesday)?|Thu(?:rsday)?|Fri(?:day)?|Sat(?:urday)?)$/i',
        // weekday pattern: (short or long)
        'calender.month'         => '/^(?:Jan(?:uary)?|Feb(?:ruary)?|Mar(?:ch)?|Apr(?:il)?|May|June?|July?|Aug(?:ust)?|Sep(?:tember)?|Oct(?:ober)?|Nov(?:ember)?|Dec(?:ember)?)$/i',

        // username pattern:
        // between 4-32 characters, consists of letters in any case, optionally numbers,
        // optionally one of the following characters "-_." (not consecutive),
        // and must always start with a letter and end with a letter or number
        'username' => '/^(?:(?![._-])(?!.*[._-]$)(?!.*?[._-]{2,})[a-z]{1}[a-z0-9._-]{3,32})$/i',

        // password pattern:
        // minimum 8 characters, consists of at least one small letter and one capital letter,
        // at least one number, at least on special character, and optionally a space
        'password' => '/^(?:.*(?=.{8,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^\p{L}\p{N}\s])(?=.*[\s])?.*)$/',

        // boolean value pattern
        'boolean'       => '/^(?:(1|y(?:es)?|t(?:rue)?|on)|(0|n(?:o)?|f(?:alse)?|off))$/i',
        // boolean true pattern
        'boolean.true'  => '/^(?:0|n(?:o)?|f(?:alse)?|off)$/i',
        // boolean false pattern
        'boolean.false' => '/^(?:1|y(?:es)?|t(?:rue)?|on)$/i',

        // uuid pattern
        'uuid'    => '/^(?:[0-9A-F]{8}-[0-9A-F]{4}-[0-9A-F]{4}-[0-9A-F]{4}-[0-9A-F]{12})$/i',
        'uuid.v1' => '/^(?:[0-9A-F]{8}-[0-9A-F]{4}-[1][0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12})$/i',
        'uuid.v2' => '/^(?:[0-9A-F]{8}-[0-9A-F]{4}-[2][0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12})$/i',
        'uuid.v3' => '/^(?:[0-9A-F]{8}-[0-9A-F]{4}-[3][0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12})$/i',
        'uuid.v4' => '/^(?:[0-9A-F]{8}-[0-9A-F]{4}-[4][0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12})$/i',
        'uuid.v5' => '/^(?:[0-9A-F]{8}-[0-9A-F]{4}-[5][0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12})$/i',
        // ascii pattern
        'ascii'       => '/^[ -~]+$/',
        // slug pattern: url safe chars (letters, numbers, and dash)
        'slug'        => '/^[a-z0-9-]+$/',
        // meta characters pattern: characters only, no letters and number
        'meta'        => '/^[^\p{L}\p{N}\s]+$/',
        // text apttern: only letters and punctuation from any language
        'text'        => '/^[\p{L} -~]+$/imu',
        // words pattern: only words from any language, letters and whitespace only
        'words'       => '/^[\p{L}\s]+$/imu',
        // spaceless pattern: anything but whitespace characters
        'spaceless'   => '/^([\S])+$/i',
        // emojis pattern
        'emoji'       => '/[^-\p{L}\x00-\x7F]+/u',
        // roman pattern: valid roman number
        'roman'       => '/^(?=[MDCLXVI])M*(C[MD]|D?C{0,3})(X[CL]|L?X{0,3})(I[XV]|V?I{0,3})$/',
        // phone pattern: valid phone number (supports: North America, Europe and most Asian and Middle East countries)
        'phone'       => '/^\+?(\d{0,3})? ?(?(?=\()(\(\d{1,3}\) ?((\d{3,5})[. -]?(\d{4})|(\d{2}[. -]?){4}))|([. -]?(\d{1,3}[. -]*)?((\d{3,5})[. -]?(\d{4})|(\d{2}[. -]?){4})))$/',
        // valid geolocation pattern
        'geolocation' => '/^(?:(?:[-+]?(?:(?:[1-8]?[0-9](?:\.[0-9]+)?)|(?:90(?:\.0+)?)))(?:\s*,\s*)(?:[-+]?(?:(?:180(?:\.0+)?)|(?:(?:1[0-7][0-9])|(?:[1-9]?[0-9]))(?:\.[0-9]+)?)))$/',

        // valid semantic version number pattern
        'version'         => '/^(?:(?:[Vv])?(?:[0-9]+\.[0-9]+\.[0-9]+)([+-][^+-][0-9A-Za-z-.]*)?)$/',
        // valid semantic version number pattern with capture groups
        'version.capture' => '/(?<=^[Vv]|^)(?:(?<major>(?:0|[1-9](?:(?:0|[1-9])+)*))[.](?<minor>(?:0|[1-9](?:(?:0|[1-9])+)*))[.](?<patch>(?:0|[1-9](?:(?:0|[1-9])+)*))(?:-(?<prerelease>(?:(?:(?:[A-Za-z]|-)(?:(?:(?:0|[1-9])|(?:[A-Za-z]|-))+)?|(?:(?:(?:0|[1-9])|(?:[A-Za-z]|-))+)(?:[A-Za-z]|-)(?:(?:(?:0|[1-9])|(?:[A-Za-z]|-))+)?)|(?:0|[1-9](?:(?:0|[1-9])+)*))(?:[.](?:(?:(?:[A-Za-z]|-)(?:(?:(?:0|[1-9])|(?:[A-Za-z]|-))+)?|(?:(?:(?:0|[1-9])|(?:[A-Za-z]|-))+)(?:[A-Za-z]|-)(?:(?:(?:0|[1-9])|(?:[A-Za-z]|-))+)?)|(?:0|[1-9](?:(?:0|[1-9])+)*)))*))?(?:[+](?<build>(?:(?:(?:[A-Za-z]|-)(?:(?:(?:0|[1-9])|(?:[A-Za-z]|-))+)?|(?:(?:(?:0|[1-9])|(?:[A-Za-z]|-))+)(?:[A-Za-z]|-)(?:(?:(?:0|[1-9])|(?:[A-Za-z]|-))+)?)|(?:(?:0|[1-9])+))(?:[.](?:(?:(?:[A-Za-z]|-)(?:(?:(?:0|[1-9])|(?:[A-Za-z]|-))+)?|(?:(?:(?:0|[1-9])|(?:[A-Za-z]|-))+)(?:[A-Za-z]|-)(?:(?:(?:0|[1-9])|(?:[A-Za-z]|-))+)?)|(?:(?:0|[1-9])+)))*))?)$/',

        // any amount pattern: only numbers, an optional decimal point (comma or dot), and an optional minus
        'amount'        => '/^(?:\-?\s?(\d+([\.,]\d+)?)+)$/i',
        // money amount for USD: "$1,234,567.89", "US$100", "$5", "-$20.99", "-$ 13.02"
        'amount.dollar' => '/^(?:\-?(?:(US?)?\$)[ ]?(?:0|(?:[1-9](?:\d{0,2}(?:,\d{3})+|\d*)))(?:\.\d{1,2}\b|))$/',
        // money amount for EUR: "1.234.567,89 €", "100 EUR", "5€", "-20,99€", "- 13,02 €"
        'amount.euro'   => '/^(?:\-?[ ]?(?:0|(?:[1-9](?:\d{0,2}(?:\.\d{3})+|\d*)))(?:,\d{1,2}\b|)(?:([ ]+EUR?|[ ]?€)))$/',

        // color pattern: valid CSS color pattern (Keyword 'loose', HEX, HEX-Alpha, RGB, RGBA, RGB 'new syntax', HSL, HSLA, HSL 'new syntax')
        'color'          => '/^((?:[abcdfghilmnoprstuwy][a-z]{1,18}[abdefhiklmnoprtuwy])|(?:#(?:[0-9a-fA-F]{3})|#(?:[0-9a-fA-F]{2}){2,4})|(?:#(?:[0-9a-fA-F]{2}){2}|#(?:[0-9a-fA-F]{2}){4})|(?:rgb\((?:\s*(?:\d|1\d{2}|[2][0-5]{2})\s*,){2}\s*(?:\d|1\d{2}|[2][0-5]{2})\s*\))|(?:rgba\((?:\s*(?:\d|1\d{2}|[2][0-5]{2})\s*,){3}\s*(?:[0]\.\d+|1)\s*\))|(?:rgb\((?:\s*(?:\d|1\d{2}|[2][0-5]{2})\s+){2}(?:\d|1\d{2}|[2][0-5]{2})(?:\s*\/\s*(?:(?:\d{1,2}|100)%|(?:[0]\.\d+|1))\s*)?\))|(?:hsl\((?:\s*(?:\d{1,3})\s*)(?:,\s*(?:\d{1,2}|100)%\s*){2}\))|(?:hsla\((?:\s*(?:\d{1,3})\s*)(?:,\s*(?:\d{1,2}|100)%\s*){2}(?:,\s*(?:(?:\d{1,2}|100)%|(?:[0]\.\d+|1))\s*)\))|(?:hsl\((?:\s*(?:\d{1,3}deg))(?:\s+(?:\d{1,2}|100)%){2}(?:\s*\/\s*(?:(?:\d{1,2}|100)%|(?:[0]\.\d+|1))\s*)?\)))$/',
        // valid CSS HEX color (3+1, 6+2)
        'color.hex'      => '/^(#(?:[0-9a-fA-F]{3})|#(?:[0-9a-fA-F]{2}){2,4})$/',
        // valid CSS HEX color (3+1)
        'color.hexShort' => '/^#(?:[0-9a-fA-F]{3})$/',
        // valid CSS HEX color (6+2)
        'color.hexLong'  => '/^#(?:[0-9a-fA-F]{2}){3}$/',
        // valid CSS HEX-Alpha color (3+1, 6+2)
        'color.hexAlpha' => '/^#(?:[0-9a-fA-F]{2}){2}|#(?:[0-9a-fA-F]{2}){4}$/',
        // valid CSS RGB color
        'color.rgb'      => '/^rgb\((?:\s*(?:\d|1\d{2}|[2][0-5]{2})\s*,){2}\s*(?:\d|1\d{2}|[2][0-5]{2})\s*\)$/',
        // valid CSS RGBA color
        'color.rgba'     => '/^rgba\((?:\s*(?:\d|1\d{2}|[2][0-5]{2})\s*,){3}\s*(?:[0]\.\d+|1)\s*\)$/',
        // valid CSS RGB color (new syntax)
        'color.rgb.new'  => '/^rgb\((?:\s*(?:\d|1\d{2}|[2][0-5]{2})\s+){2}(?:\d|1\d{2}|[2][0-5]{2})(?:\s*\/\s*(?:(?:\d{1,2}|100)%|(?:[0]\.\d+|1))\s*)?\)$/',
        // valid CSS HSL color
        'color.hsl'      => '/^hsl\((?:\s*(?:\d{1,3})\s*)(?:,\s*(?:\d{1,2}|100)%\s*){2}\)$/',
        // valid CSS HSLA color
        'color.hsla'     => '/^hsla\((?:\s*(?:\d{1,3})\s*)(?:,\s*(?:\d{1,2}|100)%\s*){2}(?:,\s*(?:(?:\d{1,2}|100)%|(?:[0]\.\d+|1))\s*)\)$/',
        // valid CSS HSL color (new syntax)
        'color.hsl.new'  => '/^hsl\((?:\s*(?:\d{1,3}deg))(?:\s+(?:\d{1,2}|100)%){2}(?:\s*\/\s*(?:(?:\d{1,2}|100)%|(?:[0]\.\d+|1))\s*)?\)$/',
        // valid CSS keyword color (strict)
        // https://www.w3.org/wiki/CSS/Properties/color/keywords
        'color.keyword'  => '/^(?:a(?:liceblue|ntiquewhite|qua(?:marine)?|zure)|b(?:eige|isque|l(?:a(?:ck|nchedalmond)|ue(?:violet)?)|rown|urlywood)|c(?:adetblue|h(?:artreuse|ocolate)|or(?:al|n(?:flowerblue|silk))|rimson|yan)|d(?:ark(?:blue|cyan|g(?:oldenrod|r(?:ay|e(?:en|y)))|khaki|magenta|o(?:livegreen|r(?:ange|chid))|red|s(?:almon|eagreen|late(?:blue|gr(?:ay|ey)))|turquoise|violet)|eep(?:pink|skyblue)|imgr(?:ay|ey)|odgerblue)|f(?:irebrick|loralwhite|orestgreen|uchsia)|g(?:ainsboro|hostwhite|old(?:enrod)?|r(?:ay|e(?:en(?:yellow)?|y)))|ho(?:neydew|tpink)|i(?:ndi(?:anred|go)|vory)|khaki|l(?:a(?:vender(?:blush)?|wngreen)|emonchiffon|i(?:ght(?:blue|c(?:oral|yan)|g(?:oldenrodyellow|r(?:ay|e(?:en|y)))|pink|s(?:almon|eagreen|kyblue|lategr(?:ay|ey)|teelblue)|yellow)|me(?:green)?|nen))|m(?:a(?:genta|roon)|edium(?:aquamarine|blue|orchid|purple|s(?:eagreen|lateblue|pringgreen)|turquoise|violetred)|i(?:dnightblue|ntcream|styrose)|occasin)|nav(?:ajowhite|y)|o(?:l(?:dlace|ive(?:drab)?)|r(?:ange(?:red)?|chid))|p(?:a(?:le(?:g(?:oldenrod|reen)|turquoise|violetred)|payawhip)|e(?:achpuff|ru)|ink|lum|owderblue|urple)|r(?:ed|o(?:sybrown|yalblue))|s(?:a(?:ddlebrown|lmon|ndybrown)|ea(?:green|shell)|i(?:enna|lver)|kyblue|late(?:blue|gr(?:ay|ey))|now|pringgreen|teelblue)|t(?:an|eal|histle|omato|urquoise)|violet|wh(?:eat|ite(?:smoke)?)|yellow(?:green)?)$/',

        // us social security number pattern
        'ssn'         => '/^(?:(?!000|666|9)\d{3}([ -]|)(?!00)\d{2}\1(?!0000)\d{4})$/',
        // ca social insurance number
        'sin'         => '/^(?:\d{3}([ -]|)\d{3}\1\d{3})$/',
        // uk national insurance number
        'nino'        => '/^(?:(?!BG|GB|NK|KN|TN|NT|ZZ)(?:[A-CEGHJ-PR-TW-Z][A-CEGHJ-NPR-TW-Z]([ -]|))(?:\d{2}\1){3}[A-D])$/',
        // vehicle identification number pattern
        'vin'         => '/^(?:[A-HJ-NPR-Z\d]{3})(?:[A-HJ-NPR-Z\d]{5})(?:[\dX])(?:(?:[A-HJ-NPR-Z\d])(?:[A-HJ-NPR-Z\d])(?:[A-HJ-NPR-Z\d]{6}))$/',
        // vehicle identification number pattern with capture groups
        'vin.capture' => '/^(?<wmi>[A-HJ-NPR-Z\d]{3})(?<vds>[A-HJ-NPR-Z\d]{5})(?<check>[\dX])(?<vis>(?<year>[A-HJ-NPR-Z\d])(?<plant>[A-HJ-NPR-Z\d])(?<sequence>[A-HJ-NPR-Z\d]{6}))$/',
        // international standard serial number pattern
        'issn'        => '/^(?:(?:(?:ISSN|eISSN):?\s*)?(?:\d{4}-?\d{3}[0-9x]))$/i',
        // international securities identification number pattern
        'isin'        => '/^(?:(?:ISIN:?\s*)?(?:(?:[A-Z]{2})([ -]|)(?:[A-Z0-9]{9})\1(?:\d{1})))$/i',
        // international standard book number ISBN-10/13 pattern
        'isbn'        => '/^(?:(?:ISBN(?:-1[03])?:?\s*)?(?=\d+([ -]|))(?:(?:\d\1\d{4}\1\d{4}\1[0-9X])|(?:97[89]\1\d\1\d{4}\1\d{4}\1\d)))$/i',
        // international standard book number ISBN-10 pattern
        'isbn.10'     => '/^(?:(?:ISBN(?:-10)?:?\s*)?\d([ -]|)\d{4}\1\d{4}\1[0-9X])$/i',
        // international standard book number ISBN-13 pattern
        'isbn.13'     => '/^(?:(?:ISBN(?:-13)?:?\s*)?97[89]([ -]|)\d\1\d{4}\1\d{4}\1\d)$/i',
        // international mobile station equipment identity number
        'imei'        => '/^(?:(?:IMEI:?\s*)?(?=\d+([ -]|))(?:\d{2}\1\d{6}\1\d{6}(?:\1\d)?))$/i',
        // international mobile station equipment identity and software version number
        'imei.sv'      => '/^(?:(?:IMEI-?SV:?\s*)?(?=\d+([ -]|))(?:\d{2}\1\d{6}\1\d{6}\1\d{2}))$/i',
        // mobile equipment identifier
        'meid'        => '/^(?:(?:MEID:?\s*)?(?=[0-9a-f]+([ -]|))(?:[0-9a-f]{2}\1[0-9a-f]{6}\1[0-9a-f]{6}(?:\1[0-9a-f])?))$/i',
        // electronic serial number
        'esn'          => '/^(?:(?:ESN:?\s*)?(?=[0-9a-f]+([ -]|))(?:[0-9a-f]{4}\1[0-9a-f]{4}))$/i',

        // currency ISO 4217 3-letter code pattern
        'currency.alpha'             => '/^(?:A(?:ED|FN|LL|MD|NG|OA|RS|UD|WG|ZN)|B(?:AM|BD|DT|GN|HD|IF|MD|ND|O[BV]|RL|SD|TN|WP|YN|ZD)|C(?:AD|DF|H[EFW]|L[FP]|O[PU]|RC|U[CP]|VE|ZK|NY)|D(?:JF|KK|OP|ZD)|E(?:GP|RN|TB|UR)|F(?:JD|KP)|G(?:BP|EL|HS|IP|MD|NF|TQ|YD)|H(?:KD|NL|RK|TG|UF)|I(?:DR|LS|NR|QD|RR|SK)|J(?:MD|OD|PY)|K(?:ES|GS|HR|MF|PW|RW|WD|YD|ZT)|L(?:AK|BP|KR|RD|SL|YD)|M(?:AD|DL|GA|KD|MK|NT|OP|RU|UR|VR|WK|X[NV]|YR|ZN)|N(?:AD|GN|IO|OK|PR|ZD)|OMR|P(?:AB|EN|GK|HP|KR|LN|YG)|QAR|R(?:ON|SD|UB|WF)|S(?:AR|BD|CR|DG|EK|GD|HP|L[LE]|OS|RD|SP|TN|VC|YP|ZL)|T(?:HB|JS|MT|ND|OP|RY|TD|WD|ZS)|U(?:AH|GX|S[DN]|Y[IUW]|ZS)|V(?:E[DS]|ND|UV)|WST|X(?:A[FGU]|B[ABCD]|CD|DR|OF|P[DFT]|SU|TS|UA|XX)|YER|Z(?:AR|MW|WL))$/',
        // currency ISO 4217 numeric code pattern
        'currency.num'               => '/^(?:0(?:08|12|3[26]|4[48]|5[012]|6[048]|72|84|9[06])|1(?:0[48]|16|24|3[26]|44|5[26]|7[04]|88|9[12])|2(?:0[38]|14|22|3[028]|42|62|70|92)|3(?:2[048]|32|4[048]|5[26]|6[048]|76|88|9[28])|4(?:0[048]|1[0478]|2[26]|3[04]|46|5[48]|62|8[04]|9[68])|5(?:04|1[26]|24|3[23]|48|5[48]|66|78|86|9[08])|6(?:0[048]|34|4[36]|54|82|9[04])|7(?:0[246]|10|28|48|5[26]|6[04]|76|8[048])|8(?:0[07]|18|26|34|40|58|60|8[26])|9(?:01|2[56789]|3[0123468]|4[01346789]|5[012356789]|6[012345789]|7[012356789]|8[01456]|9[0479]))$/',
        // currency name (as in ISO 4217) pattern
        'currency.name'              => '/^(?:a(?:fghani|riary)|b(?:a(?:ht|lboa)|irr|ol(?:iviano|ívar))|c(?:edi|ol(?:on|ón)|órdoba)|d(?:alasi|enar|i(?:gital|nar|rham)|o(?:bra|llar)|ram)|e(?:scudo|uro)|f(?:lorin|orint|ranc)|g(?:o(?:ld|urde)|u(?:araní|ilder))|hryvnia|k(?:i(?:na|p)|oruna|r(?:on(?:a|e|or)|ón(?:a|ur))|una|wa(?:cha|nza)|yat)|l(?:ari|e(?:k|mpira|one|u|v)|i(?:langeni|ra)|oti)|m(?:a(?:nat|rk)|etical)|n(?:a(?:ira|kfa)|gultrum)|ouguiya|p(?:a(?:lladium|taca|ʻanga)|eso|latinum|ound|revisional|ula)|quetzal|r(?:and|e(?:al|nminbi)|i(?:al|el|nggit|yal)|u(?:ble|fiyaa|p(?:ee|iah)))|s(?:h(?:ekel|illing)|ilver|o(?:berano|l|m(?:oni)?)|terling)|t(?:a(?:ka|la)|enge|ögrög)|vatu|won|yen|złoty|đồng)$/iu',
        // credit card general pattern
        // have a length of 12-19 digits in sets of 4 digits separated by space, dash, or nothing
        'creditcard'                 => '/^(?=[0-9]{4}([ -]|))(?:[0-9]{4}\1?){3,}(?:[0-9]{0,4})$/',
        // Visa credit card numbers start with a 4
        // and have a length of 13, 16, or 19 digits in sets of 4 digits
        // separated by space, dash, or nothing
        'creditcard.visa'            => '/^(?=[0-9]{4}([ -]|))(?:4[0-9]{3})\1(?:(?:[0-9]{4}\1){2}(?:[0-9]|[0-9]{4})|(?:[0-9]{4}\1){3}(?:[0-9]{3}))$/',
        // MasterCard credit card numbers start with the numbers 51-55,
        // or 222[1-9], 22[3-9][0-9], 2[3-6][0-9]{2}, 27[01][0-9], and 2720
        // and have a length of 16 digits in sets of 4 digits (4-4-4-4)
        // separated by space, dash, or nothing
        'creditcard.mastercard'      => '/^(?=[0-9]{4}([ -]|))(?:5[1-5][0-9]{2}|222[1-9]|22[3-9][0-9]|2[3-6][0-9]{2}|27[01][0-9]|2720)\1(?:(?:[0-9]{4}\1){2}[0-9]{4})$/',
        // Discover credit card numbers begin with 6011, 644-649, 65, 622126-622925
        // and have a length of 16 digits in sets of 4 digits (4-4-4-4)
        // separated by space, dash, or nothing
        'creditcard.discover'        => '/^(?=[0-9]{4}([ -]|))(?:(?:6(?:011|4[4-9][0-9]|5[0-9][0-9]))\1(?:(?:[0-9]{4}\1){2}[0-9]{4})|(?:622[2-8])\1(?:(?:[0-9]{4}\1){2}[0-9]{4})|(?:6221)\1(?:(?:26[0-9]{2})(?:\1[0-9]{4}){2})|(?:6229)\1(?:(?:25[0-9]{2})(?:\1[0-9]{4}){2}))$/',
        // American Express credit card numbers start with 34 or 37
        // and have a length of 15 digits in sets of 4 digits (4-4-4-4, 4-6-5)
        // separated by space, dash, or nothing
        'creditcard.americanExpress' => '/(?=[0-9]{4}([ -]|))(?:3[47][0-9]{2})\1(?:(?:[0-9]{6}\1[0-9]{5})|(?:(?:[0-9]{4}\1){2}[0-9]{3}))/',
        // Diners Club credit card numbers begin with 300-305, 36 or 38
        // and have a length of 14 digits in sets of 4 digits (4-4-4-2)
        // separated by space, dash, or nothing
        // there are also cards that begin with 2014 and 2149
        // and have a length of 15 digits in sets of 4 digits (4-4-4-3)
        // separated by space, dash, or nothing
        // there are also cards that begin with 5 and have 16 digits (joint venture),
        // these should be treadted and processed like a MasterCard.
        'creditcard.dinersClub'      => '/^(?=[0-9]{4}([ -]|))(?:(?:3(?:0[0-5]|[68][0-9])[0-9])\1(?:(?:[0-9]{4}\1){2}[0-9]{2})|2(?:014|149)\1(?:(?:[0-9]{4}\1){2}[0-9]{3}))$/',
        // JCB credit card numbers begin with 2131 or 1800
        // and have a length of 15 digits in sets of 4 digits (4-4-4-3)
        // separated by space, dash, or nothing
        // there are also cards that begin with 35 and have 16 digits (4-4-4-4)
        // separated by space, dash, or nothing
        'creditcard.jcb'             => '/^(?=[0-9]{4}([ -]|))(?:(?:2131|1800)\1(?:(?:[0-9]{4}\1){2}[0-9]{3})|(?:2131|1800|35[0-9]{2})\1(?:(?:[0-9]{4}\1){2}[0-9]{4}))$/',
        // Maestro international credit card numbers begin with 675900-675999
        // Maestro UK cards begin with either 500000-509999 or 560000-699999
        // both have a length of 12-19 digits in sets of 4 digits
        // (4-4-4, 4-4-4-1, 4-4-4-2, 4-4-4-3, 4-4-4-4, 4-4-4-4-1, 4-4-4-4-2, 4-4-4-4-3)
        // separated by space, dash, or nothing
        'creditcard.maestro'         => '/^(?=[0-9]{4}([ -]|))(?:(?:50|5[6-9]|6[0-9])[0-9]{2})\1(?:(?:[0-9]{4}\1){2,3}[0-9]{1,4})$/',
        // China UnionPay credit card numbers begin with 62
        // and have a length of 16-19 digits in sets of 4 digits
        // (4-4-4, 4-4-4-1, 4-4-4-2, 4-4-4-3, 4-4-4-4)
        // separated by space, dash, or nothing
        // note that these cards do not follow Luhn Algorithm
        'creditcard.chinaUnionPay'   => '/^(?=[0-9]{4}([ -]|))(?:62[0-9]{2})\1(?:(?:[0-9]{4}\1){2}[0-9]{4})$/',
        // InstaPayment credit card numbers begin with 637-639
        // and have a length of 16 digits in sets of 4 digits (4-4-4-4)
        // separated by space, dash, or nothing
        'creditcard.instaPayment'    => '/^(?=[0-9]{4}([ -]|))(?:63[7-9][0-9])\1(?:(?:[0-9]{4}\1){2}[0-9]{4})$/',
        // Laser credit card numbers begin with either 6304, 6706, 6709 or 6771
        // and have a length of 16 or 19 digits in sets of 4 digits (4-4-4-4, 4-4-4-4-3)
        // separated by space, dash, or nothing
        'creditcard.laser'           => '/^(?=[0-9]{4}([ -]|))(?:6304|670[69]|6771)\1(?:(?:(?:[0-9]{4}\1){2}[0-9]{4})|(?:(?:[0-9]{4}\1){3}[0-9]{3}))$/',
        // UATP credit card numbers begin with a 1
        // and have a length of 15 digits in sets of 4 digits (4-4-4-3)
        'creditcard.uatp'            => '/^(?=[0-9]{4}([ -]|))(?:1[0-9]{3})\1(?:(?:[0-9]{4}\1){2}[0-9]{3})$/',
        // MIR Payment System cards numbers start with 220, then 1 digit from 0 to 4
        // and have a length of 16-19 digits in sets of 4 digits
        // (4-4-4-4, 4-4-4-4-1, 4-4-4-4-2, 4-4-4-4-3)
        // separated by space, dash, or nothing
        'creditcard.mir'             => '/^(?=[0-9]{4}([ -]|))(?:220[0-4])\1(?:(?:[0-9]{4}\1){2,3}[0-9]{2,4})$/',
        // cvv general pattern
        'cvv'                        => '/^(?:[0-9]{3,4})$/',
        // bic general pattern
        'bic'                        => '/^(?:[A-Z]{6}[2-9A-Z][0-9A-NP-Z](XXX|[0-9A-WYZ][0-9A-Z]{2})?)$/i',
        // iban general pattern
        // see https://en.wikipedia.org/wiki/International_Bank_Account_Number#IBAN_formats_by_country (2022-07-12)
        'iban'                       => '/^(?:AD[0-9]{10}[A-Z0-9]{12}|AE[0-9]{21}|AL[0-9]{10}[A-Z0-9]{16}|AT[0-9]{18}|AZ[0-9]{2}[A-Z]{4}[A-Z0-9]{20}|BA[0-9]{18}|BE[0-9]{14}|BG[0-9]{2}[A-Z]{4}[0-9]{6}[A-Z0-9]{8}|BH[0-9]{2}[A-Z]{4}[A-Z0-9]{14}|BR[0-9]{25}[A-Z]{1}[A-Z0-9]{1}|BY[0-9]{2}[A-Z0-9]{4}[0-9]{4}[A-Z0-9]{16}|CH[0-9]{7}[A-Z0-9]{12}|CR[0-9]{20}|CY[0-9]{10}[A-Z0-9]{16}|CZ[0-9]{22}|DE[0-9]{20}|DK[0-9]{16}|DO[0-9]{2}[A-Z0-9]{4}[0-9]{20}|EE[0-9]{18}|EG[0-9]{27}|ES[0-9]{22}|FI[0-9]{16}|FO[0-9]{16}|FR[0-9]{12}[A-Z0-9]{11}[0-9]{2}|GB[0-9]{2}[A-Z]{4}[0-9]{14}|GE[0-9]{2}[A-Z]{2}[0-9]{16}|GI[0-9]{2}[A-Z]{4}[A-Z0-9]{15}|GL[0-9]{16}|GR[0-9]{9}[A-Z0-9]{16}|GT[0-9]{2}[A-Z0-9]{24}|HR[0-9]{19}|HU[0-9]{26}|IE[0-9]{2}[A-Z]{4}[0-9]{14}|IL[0-9]{21}|IQ[0-9]{2}[A-Z]{4}[0-9]{15}|IS[0-9]{24}|IT[0-9]{2}[A-Z]{1}[0-9]{10}[A-Z0-9]{12}|JO[0-9]{2}[A-Z]{4}[0-9]{4}[A-Z0-9]{18}|KW[0-9]{2}[A-Z]{4}[A-Z0-9]{22}|KZ[0-9]{5}[A-Z0-9]{13}|LB[0-9]{6}[A-Z0-9]{20}|LC[0-9]{2}[A-Z]{4}[A-Z0-9]{24}|LI[0-9]{7}[A-Z0-9]{12}|LT[0-9]{18}|LU[0-9]{5}[A-Z0-9]{13}|LV[0-9]{2}[A-Z]{4}[A-Z0-9]{13}|LY[0-9]{23}|MC[0-9]{12}[A-Z0-9]{11}[0-9]{2}|MD[0-9]{2}[A-Z0-9]{20}|ME[0-9]{20}|MK[0-9]{5}[A-Z0-9]{10}[0-9]{2}|MR[0-9]{25}|MT[0-9]{2}[A-Z]{4}[0-9]{5}[A-Z0-9]{18}|MU[0-9]{2}[A-Z]{4}[0-9]{19}[A-Z]{3}|NL[0-9]{2}[A-Z]{4}[0-9]{10}|NO[0-9]{13}|PK[0-9]{2}[A-Z]{4}[A-Z0-9]{16}|PL[0-9]{26}|PS[0-9]{2}[A-Z]{4}[A-Z0-9]{21}|PT[0-9]{23}|QA[0-9]{2}[A-Z]{4}[A-Z0-9]{21}|RO[0-9]{2}[A-Z]{4}[A-Z0-9]{16}|RS[0-9]{20}|SA[0-9]{4}[A-Z0-9]{18}|SC[0-9]{2}[A-Z]{4}[0-9]{20}[A-Z]{3}|SD[0-9]{16}|SE[0-9]{22}|SI[0-9]{17}|SK[0-9]{22}|SM[0-9]{2}[A-Z]{1}[0-9]{10}[A-Z0-9]{12}|ST[0-9]{23}|SV[0-9]{2}[A-Z]{4}[0-9]{20}|TL[0-9]{21}|TN[0-9]{22}|TR[0-9]{8}[A-Z0-9]{16}|UA[0-9]{8}[A-Z0-9]{19}|VA[0-9]{20}|VG[0-9]{2}[A-Z]{4}[0-9]{16}|XK[0-9]{18})$/i',
        // iban country specific patterns
        'iban.ad'                    => '/^(?:AD[0-9]{10}[A-Z0-9]{12})$/',
        'iban.ae'                    => '/^(?:AE[0-9]{21})$/',
        'iban.al'                    => '/^(?:AL[0-9]{10}[A-Z0-9]{16})$/',
        'iban.at'                    => '/^(?:AT[0-9]{18})$/',
        'iban.az'                    => '/^(?:AZ[0-9]{2}[A-Z]{4}[A-Z0-9]{20})$/',
        'iban.ba'                    => '/^(?:BA[0-9]{18})$/',
        'iban.be'                    => '/^(?:BE[0-9]{14})$/',
        'iban.bg'                    => '/^(?:BG[0-9]{2}[A-Z]{4}[0-9]{6}[A-Z0-9]{8})$/',
        'iban.bh'                    => '/^(?:BH[0-9]{2}[A-Z]{4}[A-Z0-9]{14})$/',
        'iban.br'                    => '/^(?:BR[0-9]{25}[A-Z]{1}[A-Z0-9]{1})$/',
        'iban.by'                    => '/^(?:BY[0-9]{2}[A-Z0-9]{4}[0-9]{4}[A-Z0-9]{16})$/',
        'iban.ch'                    => '/^(?:CH[0-9]{7}[A-Z0-9]{12})$/',
        'iban.cr'                    => '/^(?:CR[0-9]{20})$/',
        'iban.cy'                    => '/^(?:CY[0-9]{10}[A-Z0-9]{16})$/',
        'iban.cz'                    => '/^(?:CZ[0-9]{22})$/',
        'iban.de'                    => '/^(?:DE[0-9]{20})$/',
        'iban.dk'                    => '/^(?:DK[0-9]{16})$/',
        'iban.do'                    => '/^(?:DO[0-9]{2}[A-Z0-9]{4}[0-9]{20})$/',
        'iban.ee'                    => '/^(?:EE[0-9]{18})$/',
        'iban.eg'                    => '/^(?:EG[0-9]{27})$/',
        'iban.es'                    => '/^(?:ES[0-9]{22})$/',
        'iban.fi'                    => '/^(?:FI[0-9]{16})$/',
        'iban.fo'                    => '/^(?:FO[0-9]{16})$/',
        'iban.fr'                    => '/^(?:FR[0-9]{12}[A-Z0-9]{11}[0-9]{2})$/',
        'iban.gb'                    => '/^(?:GB[0-9]{2}[A-Z]{4}[0-9]{14})$/',
        'iban.ge'                    => '/^(?:GE[0-9]{2}[A-Z]{2}[0-9]{16})$/',
        'iban.gi'                    => '/^(?:GI[0-9]{2}[A-Z]{4}[A-Z0-9]{15})$/',
        'iban.gl'                    => '/^(?:GL[0-9]{16})$/',
        'iban.gr'                    => '/^(?:GR[0-9]{9}[A-Z0-9]{16})$/',
        'iban.gt'                    => '/^(?:GT[0-9]{2}[A-Z0-9]{24})$/',
        'iban.hr'                    => '/^(?:HR[0-9]{19})$/',
        'iban.hu'                    => '/^(?:HU[0-9]{26})$/',
        'iban.ie'                    => '/^(?:IE[0-9]{2}[A-Z]{4}[0-9]{14})$/',
        'iban.il'                    => '/^(?:IL[0-9]{21})$/',
        'iban.iq'                    => '/^(?:IQ[0-9]{2}[A-Z]{4}[0-9]{15})$/',
        'iban.is'                    => '/^(?:IS[0-9]{24})$/',
        'iban.it'                    => '/^(?:IT[0-9]{2}[A-Z]{1}[0-9]{10}[A-Z0-9]{12})$/',
        'iban.jo'                    => '/^(?:JO[0-9]{2}[A-Z]{4}[0-9]{4}[A-Z0-9]{18})$/',
        'iban.kw'                    => '/^(?:KW[0-9]{2}[A-Z]{4}[A-Z0-9]{22})$/',
        'iban.kz'                    => '/^(?:KZ[0-9]{5}[A-Z0-9]{13})$/',
        'iban.lb'                    => '/^(?:LB[0-9]{6}[A-Z0-9]{20})$/',
        'iban.lc'                    => '/^(?:LC[0-9]{2}[A-Z]{4}[A-Z0-9]{24})$/',
        'iban.li'                    => '/^(?:LI[0-9]{7}[A-Z0-9]{12})$/',
        'iban.lt'                    => '/^(?:LT[0-9]{18})$/',
        'iban.lu'                    => '/^(?:LU[0-9]{5}[A-Z0-9]{13})$/',
        'iban.lv'                    => '/^(?:LV[0-9]{2}[A-Z]{4}[A-Z0-9]{13})$/',
        'iban.ly'                    => '/^(?:LY[0-9]{23})$/',
        'iban.mc'                    => '/^(?:MC[0-9]{12}[A-Z0-9]{11}[0-9]{2})$/',
        'iban.md'                    => '/^(?:MD[0-9]{2}[A-Z0-9]{20})$/',
        'iban.me'                    => '/^(?:ME[0-9]{20})$/',
        'iban.mk'                    => '/^(?:MK[0-9]{5}[A-Z0-9]{10}[0-9]{2})$/',
        'iban.mr'                    => '/^(?:MR[0-9]{25})$/',
        'iban.mt'                    => '/^(?:MT[0-9]{2}[A-Z]{4}[0-9]{5}[A-Z0-9]{18})$/',
        'iban.mu'                    => '/^(?:MU[0-9]{2}[A-Z]{4}[0-9]{19}[A-Z]{3})$/',
        'iban.nl'                    => '/^(?:NL[0-9]{2}[A-Z]{4}[0-9]{10})$/',
        'iban.no'                    => '/^(?:NO[0-9]{13})$/',
        'iban.pk'                    => '/^(?:PK[0-9]{2}[A-Z]{4}[A-Z0-9]{16})$/',
        'iban.pl'                    => '/^(?:PL[0-9]{26})$/',
        'iban.ps'                    => '/^(?:PS[0-9]{2}[A-Z]{4}[A-Z0-9]{21})$/',
        'iban.pt'                    => '/^(?:PT[0-9]{23})$/',
        'iban.qa'                    => '/^(?:QA[0-9]{2}[A-Z]{4}[A-Z0-9]{21})$/',
        'iban.ro'                    => '/^(?:RO[0-9]{2}[A-Z]{4}[A-Z0-9]{16})$/',
        'iban.rs'                    => '/^(?:RS[0-9]{20})$/',
        'iban.sa'                    => '/^(?:SA[0-9]{4}[A-Z0-9]{18})$/',
        'iban.sc'                    => '/^(?:SC[0-9]{2}[A-Z]{4}[0-9]{20}[A-Z]{3})$/',
        'iban.sd'                    => '/^(?:SD[0-9]{16})$/',
        'iban.se'                    => '/^(?:SE[0-9]{22})$/',
        'iban.si'                    => '/^(?:SI[0-9]{17})$/',
        'iban.sk'                    => '/^(?:SK[0-9]{22})$/',
        'iban.sm'                    => '/^(?:SM[0-9]{2}[A-Z]{1}[0-9]{10}[A-Z0-9]{12})$/',
        'iban.st'                    => '/^(?:ST[0-9]{23})$/',
        'iban.sv'                    => '/^(?:SV[0-9]{2}[A-Z]{4}[0-9]{20})$/',
        'iban.tl'                    => '/^(?:TL[0-9]{21})$/',
        'iban.tn'                    => '/^(?:TN[0-9]{22})$/',
        'iban.tr'                    => '/^(?:TR[0-9]{8}[A-Z0-9]{16})$/',
        'iban.ua'                    => '/^(?:UA[0-9]{8}[A-Z0-9]{19})$/',
        'iban.va'                    => '/^(?:VA[0-9]{20})$/',
        'iban.vg'                    => '/^(?:VG[0-9]{2}[A-Z]{4}[0-9]{16})$/',
        'iban.xk'                    => '/^(?:XK[0-9]{18})$/',
    ];


    private function __construct()
    {
        // prevent class from being instantiated
    }
}
