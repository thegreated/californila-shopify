{%- style -%}
  {%- assign logo_max_width = section.settings.logo_max_width -%}
  {%- assign header_color = section.settings.header_color -%}

  {%- if section.settings.transparent_header_enable and request.page_type == 'index' -%}
    {%- assign header_color_transparent = section.settings.transparent_header_color -%}

    .header-wrapper.header-wrapper--transparent .site-nav__link,
    .header-wrapper.header-wrapper--transparent .site-header__logo a {
      color: {{ header_color_transparent }};
    }

    .header-wrapper.header-wrapper--transparent .site-header__logo a:hover,
    .header-wrapper.header-wrapper--transparent .site-nav__link:hover,
    .header-wrapper.header-wrapper--transparent .site-nav__link:focus,
    .header-wrapper.header-wrapper--transparent .site-header__logo a:focus {
      color: {{ header_color_transparent | color_modify: 'alpha', 0.75 }};
    }

    .header-wrapper.header-wrapper--transparent .site-nav--has-dropdown.nav-hover > .site-nav__link {
      color: {{ header_color }};
    }

    .header-wrapper.header-wrapper--transparent .burger-icon,
    .header-wrapper.header-wrapper--transparent .site-nav__link:hover .burger-icon {
      background: {{ header_color_transparent }};
    }
  {%- endif -%}

  .header-wrapper .site-nav__link,
  .header-wrapper .site-header__logo a,
  .header-wrapper .site-nav__dropdown-link,
  .header-wrapper .site-nav--has-dropdown > a.nav-focus,
  .header-wrapper .site-nav--has-dropdown.nav-hover > a,
  .header-wrapper .site-nav--has-dropdown:hover > a {
    color: {{ header_color }};
  }

  .header-wrapper .site-header__logo a:hover,
  .header-wrapper .site-header__logo a:focus,
  .header-wrapper .site-nav__link:hover,
  .header-wrapper .site-nav__link:focus,
  .header-wrapper .site-nav--has-dropdown a:hover,
  .header-wrapper .site-nav--has-dropdown > a.nav-focus:hover,
  .header-wrapper .site-nav--has-dropdown > a.nav-focus:focus,
  .header-wrapper .site-nav--has-dropdown .site-nav__link:hover,
  .header-wrapper .site-nav--has-dropdown .site-nav__link:focus,
  .header-wrapper .site-nav--has-dropdown.nav-hover > a:hover,
  .header-wrapper .site-nav__dropdown a:focus {
    color: {{ header_color | color_modify: 'alpha', 0.75 }};
  }

  .header-wrapper .burger-icon,
  .header-wrapper .site-nav--has-dropdown:hover > a:before,
  .header-wrapper .site-nav--has-dropdown > a.nav-focus:before,
  .header-wrapper .site-nav--has-dropdown.nav-hover > a:before {
    background: {{ header_color }};
  }

  .header-wrapper .site-nav__link:hover .burger-icon {
    background: {{ header_color | color_modify: 'alpha', 0.75 }};
  }

  .site-header__logo img {
    max-width: {{ logo_max_width | append: 'px' }};
  }

  @media screen and (max-width: 768px) {
    .site-header__logo img {
      max-width: 100%;
    }
  }
{%- endstyle -%}
<div data-section-id="{{ section.id }}" data-section-type="header-section" data-template="{{ request.page_type }}">
  <div id="NavDrawer" class="drawer drawer--left">
    {% include 'drawer-menu' %}
  </div>
  <div class="header-container drawer__header-container">
    <div class="header-wrapper" data-header-wrapper>
      {% if section.settings.show_announcement %}
        {% if section.settings.home_page_only == false or request.page_type == 'index' %}
          <style>
            .announcement-bar {
              background-color: {{ section.settings.color_bg }};
            }

            .announcement-bar--link:hover {
              {% assign brightness = section.settings.color_bg | color_brightness %}

              {% if brightness <= 192 %}
                {% assign lightenAmount = 255 | minus: brightness | divided_by: 255 | times: 16 %}
                background-color: {{ section.settings.color_bg | color_lighten: lightenAmount }};
              {% else %}
                {% assign darkenAmount = 255 | divided_by: brightness | times: 8 %}
                background-color: {{ section.settings.color_bg | color_darken: darkenAmount }};
              {% endif %}
            }

            .announcement-bar__message {
              color: {{ section.settings.color_text }};
            }
          </style>

          {% if section.settings.link == blank %}
            <div class="announcement-bar">
          {% else %}
            <a href="{{ section.settings.link }}" class="announcement-bar announcement-bar--link">
          {% endif %}

            <p class="announcement-bar__message">{{ section.settings.text | escape }}</p>

          {% if section.settings.link == blank %}
            </div>
          {% else %}
            </a>
          {% endif %}

        {% endif %}
      {% endif %}

      <header class="site-header" role="banner"{% if section.settings.transparent_header_enable %} data-transparent-header="true"{% endif %}>
        <div class="wrapper">
          <div class="grid--full grid--table">
            <div class="grid__item large--hide large--one-sixth one-quarter">
              <div class="site-nav--open site-nav--mobile">
                <button type="button" class="icon-fallback-text site-nav__link site-nav__link--burger js-drawer-open-button-left" aria-controls="NavDrawer">
                  <span class="burger-icon burger-icon--top"></span>
                  <span class="burger-icon burger-icon--mid"></span>
                  <span class="burger-icon burger-icon--bottom"></span>
                  <span class="fallback-text">{{ 'general.drawers.navigation' | t }}</span>
                </button>
              </div>
            </div>
            <div class="grid__item large--one-third medium-down--one-half">
              {% comment %}
                Use the uploaded logo from theme settings if enabled.
                Site name gets precedence with H1 tag on homepage, div on other pages.
              {% endcomment %}
              {% if request.page_type == 'index' %}
                <h1 class="site-header__logo large--left" itemscope itemtype="http://schema.org/Organization">
              {% else %}
                <div class="h1 site-header__logo large--left" itemscope itemtype="http://schema.org/Organization">
              {% endif %}
                {% capture image_size %}{{ logo_max_width | escape }}x{% endcapture %}

                <a href="{{ routes.root_url }}" itemprop="url" class="site-header__logo-link">
                  {% if section.settings.logo %}
                    <img class="site-header__logo-image" src="{{ section.settings.logo | img_url: image_size }}" srcset="{{ section.settings.logo | img_url: image_size }} 1x, {{ section.settings.logo | img_url: image_size, scale: 2 }} 2x" alt="{{ section.settings.logo.alt | default: shop.name }}" itemprop="logo">

                    {% if request.page_type == 'index' and section.settings.transparent_header_enable %}
                      {% if section.settings.transparent_logo == blank %}
                        {%- assign transparent_logo = section.settings.logo -%}
                      {% else %}
                        {%- assign transparent_logo = section.settings.transparent_logo -%}
                      {% endif %}

                      <img class="site-header__logo-image site-header__logo-image--transparent" src="{{ transparent_logo | img_url: image_size }}" srcset="{{ transparent_logo | img_url: image_size }} 1x, {{ transparent_logo | img_url: image_size, scale: 2 }} 2x" alt="{{ section.settings.logo.alt | default: shop.name }}" itemprop="logo">
                    {% endif %}
                  {% else %}
                    {{ shop.name }}
                  {% endif %}
                </a>
              {% if request.page_type == 'index' %}
                </h1>
              {% else %}
                </div>
              {% endif %}
            </div>
            <nav class="grid__item large--two-thirds large--text-right medium-down--hide" role="navigation">
              {% comment %}
                List out your main-menu linklist (default)

                More info on linklists:
                  - http://docs.shopify.com/themes/liquid-variables/linklists
              {% endcomment %}
              <!-- begin site-nav -->
              <ul class="site-nav" id="AccessibleNav">
                {% for link in linklists[section.settings.main_menu_link_list].links %}
                  {% if link.links != blank %}
                  {% assign parent_index = forloop.index %}
                    <li
                      class="site-nav__item site-nav--has-dropdown {% if link.active %}site-nav--active{% endif %}"
                      aria-haspopup="true"
                      data-meganav-type="parent">
                      <a
                        href="{{ link.url }}"
                        class="site-nav__link"
                        data-meganav-type="parent"
                        aria-controls="MenuParent-{{ parent_index }}"
                        aria-expanded="false"
                        {% unless request.page_type == 'index' %}{% if link.active %}aria-current="page"{% endif %}{% endunless%}>
                          {{ link.title | escape }}
                          <span class="icon icon-arrow-down" aria-hidden="true"></span>
                      </a>
                      <ul
                        id="MenuParent-{{ parent_index }}"
                        class="site-nav__dropdown {% if link.levels == 2 %}site-nav--has-grandchildren{% endif %}"
                        data-meganav-dropdown>
                        {% for childlink in link.links %}
                          {% if childlink.links != blank %}
                          {% assign child_index = forloop.index %}
                            <li
                              class="site-nav__item site-nav--has-dropdown site-nav--has-dropdown-grandchild {% if childlink.active %}site-nav--active{% endif %}"
                              aria-haspopup="true">
                              <a
                                href="{{ childlink.url }}"
                                class="site-nav__dropdown-link"
                                aria-controls="MenuChildren-{{ parent_index }}-{{ child_index }}"
                                data-meganav-type="parent"
                                {% unless request.page_type == 'index' %}{% if childlink.active %}aria-current="page"{% endif %}{% endunless%}
                                tabindex="-1">
                                  {{ childlink.title | escape }}
                                  <span class="icon icon-arrow-down" aria-hidden="true"></span>
                              </a>
                              <div class="site-nav__dropdown-grandchild">
                                <ul
                                  id="MenuChildren-{{ parent_index }}-{{ child_index }}"
                                  data-meganav-dropdown>
                                  {% for grandchildlink in childlink.links %}
                                    <li{% if grandchildlink.active %} class="site-nav--active"{% endif %}>
                                      <a
                                        href="{{ grandchildlink.url }}"
                                        class="site-nav__dropdown-link"
                                        data-meganav-type="child"
                                        {% unless request.page_type == 'index' %}{% if grandchildlink.active %}aria-current="page"{% endif %}{% endunless %}
                                        tabindex="-1">
                                          {{ grandchildlink.title | escape }}
                                        </a>
                                    </li>
                                  {% endfor %}
                                </ul>
                              </div>
                            </li>
                          {% else %}
                            <li{% if childlink.active %} class="site-nav--active"{% endif %}>
                              <a
                                href="{{ childlink.url }}"
                                class="site-nav__dropdown-link"
                                data-meganav-type="child"
                                {% if childlink.active %}aria-current="page"{% endif %}
                                tabindex="-1">
                                  {{ childlink.title | escape }}
                              </a>
                            </li>
                          {% endif %}
                        {% endfor %}
                      </ul>
                    </li>
                  {% else %}
                    <li class="site-nav__item{% if link.active %} site-nav--active{% endif %}">
                      <a
                        href="{{ link.url }}"
                        class="site-nav__link"
                        data-meganav-type="child"
                        {% unless request.page_type == 'index' %}{% if link.active %}aria-current="page"{% endif %}{% endunless%}>
                          {{ link.title | escape }}
                      </a>
                    </li>
                  {% endif %}
                {% endfor %}

                {% comment %}
                  Remove comment tags below to add a search box to your header, visible on screens where your header menu
                  is displayed inline.
                  <li class="site-nav__item site-nav--search__bar medium-down--hide">
                    {% include 'search-bar', search_btn_style: 'btn', search_bar_location: 'search-bar--header' %}
                  </li>
                {% endcomment %}
                {% if shop.customer_accounts_enabled %}
                  <li class="site-nav__item site-nav__expanded-item site-nav__item--compressed">
                    <a class="site-nav__link site-nav__link--icon" href="{{ shop.url }}/pages/dashboard">
                      <span class="icon-fallback-text">
                        <span class="icon icon-customer" aria-hidden="true"></span>
                        <span class="fallback-text">
                          {% if customer %}
                            {{ 'layout.customer.account' | t }}
                          {% else %}
                            {{ 'layout.customer.log_in' | t }}
                          {% endif %}
                        </span>
                      </span>
                    </a>
                  </li>
                {% endif %}

                {% if section.settings.search == 'page' or section.settings.search == 'modal' %}
                  {% assign search_modal = true %}
                  {% if section.settings.search == 'page' %}
                    {% assign search_modal = false %}
                  {% endif %}
                  <li class="site-nav__item site-nav__item--compressed">
                    <a href="{{ routes.search_url }}" class="site-nav__link site-nav__link--icon{% if search_modal %} js-toggle-search-modal{% endif %}" data-mfp-src="#SearchModal">
                      <span class="icon-fallback-text">
                        <span class="icon icon-search" aria-hidden="true"></span>
                        <span class="fallback-text">{{ 'general.search.title' | t }}</span>
                      </span>
                    </a>
                  </li>
                {% endif %}

                <!--<li class="site-nav__item site-nav__item--compressed">
                  <a href="{{ routes.cart_url }}" class="site-nav__link site-nav__link--icon cart-link js-drawer-open-button-right" aria-controls="CartDrawer">
                    <span class="icon-fallback-text">
                      <span class="icon icon-cart" aria-hidden="true"></span>
                      <span class="fallback-text">{{ 'layout.cart.title' | t }}</span>
                    </span>
                    <span class="cart-link__bubble{% if cart.item_count > 0 %} cart-link__bubble--visible{% endif %}"></span>
                  </a>
                </li> -->

              </ul>
              <!-- //site-nav -->
            </nav>
            <div class="grid__item large--hide one-quarter">
              <div class="site-nav--mobile text-right">
                <a href="{{ routes.cart_url }}" class="site-nav__link cart-link js-drawer-open-button-right" aria-controls="CartDrawer">
                  <span class="icon-fallback-text">
                    <span class="icon icon-cart" aria-hidden="true"></span>
                    <span class="fallback-text">{{ 'layout.cart.title' | t }}</span>
                  </span>
                  <span class="cart-link__bubble{% if cart.item_count > 0 %} cart-link__bubble--visible{% endif %}"></span>
                </a>
              </div>
            </div>
          </div>

        </div>
      </header>
    </div>
  </div>
</div>



{% schema %}
{
  "name": {
    "cs": "Záhlaví",
    "da": "Overskrift",
    "de": "Header",
    "en": "Header",
    "es": "Encabezado",
    "fi": "Ylätunniste",
    "fr": "En-tête",
    "it": "header",
    "ja": "ヘッダー",
    "ko": "헤더",
    "nb": "Header",
    "nl": "Koptekst",
    "pl": "Nagłówek",
    "pt-BR": "Cabeçalho",
    "pt-PT": "Cabeçalho",
    "sv": "Rubrik",
    "th": "ส่วนหัว",
    "tr": "Üstbilgi",
    "vi": "Đầu trang",
    "zh-CN": "标头",
    "zh-TW": "標頭"
  },
  "settings": [
    {
      "type": "image_picker",
      "id": "logo",
      "label": {
        "cs": "Logo",
        "da": "Logo",
        "de": "Logo",
        "en": "Logo",
        "es": "Logo",
        "fi": "Logo",
        "fr": "Logo",
        "it": "Logo",
        "ja": "ロゴ",
        "ko": "로고",
        "nb": "Logo",
        "nl": "Logo",
        "pl": "Logo",
        "pt-BR": "Logo",
        "pt-PT": "Logótipo",
        "sv": "Logotyp",
        "th": "โลโก้",
        "tr": "Logo",
        "vi": "Logo",
        "zh-CN": "logo",
        "zh-TW": "商標"
      }
    },
    {
      "type": "range",
      "id": "logo_max_width",
      "label": {
        "cs": "Šířka vlastního loga",
        "da": "Tilpasset logobredde",
        "de": "Logobreite",
        "en": "Custom logo width",
        "es": "Ancho del logo personalizado",
        "fi": "Mukautetun logon leveys",
        "fr": "Largeur personnalisée du logo",
        "it": "Larghezza logo personalizzato",
        "ja": "ロゴの幅をカスタマイズする",
        "ko": "사용자 지정 로고 폭",
        "nb": "Tilpasset logobredde",
        "nl": "Aangepaste logo-breedte",
        "pl": "Niestandardowa szerokość logo",
        "pt-BR": "Largura do logo personalizado",
        "pt-PT": "Largura de logótipo personalizada",
        "sv": "Anpassad logotypsbredd",
        "th": "ความกว้างของโลโก้ที่กำหนดเอง",
        "tr": "Özel logo genişliği",
        "vi": "Chiều rộng logo tùy chỉnh",
        "zh-CN": "自定义 logo 宽度",
        "zh-TW": "自訂商標寬度"
      },
      "min": 50,
      "max": 260,
      "step": 5,
      "unit": "px",
      "default": 180
    },
    {
      "type": "color",
      "id": "header_color",
      "label": {
        "cs": "Odkazy a ikony",
        "da": "Links og ikoner",
        "de": "Links und Symbole",
        "en": "Links and icons",
        "es": "Enlaces e íconos",
        "fi": "Linkit ja kuvakkeet",
        "fr": "Liens et icônes",
        "it": "Link e icone",
        "ja": "リンクとアイコン",
        "ko": "링크와 아이콘",
        "nb": "Koblinger og ikoner",
        "nl": "Links en pictogrammen",
        "pl": "Linki i ikony",
        "pt-BR": "Links e ícones",
        "pt-PT": "Ligações e ícones",
        "sv": "Länkar och ikoner",
        "th": "ลิงก์และไอคอน",
        "tr": "Bağlantılar ve simgeler",
        "vi": "Liên kết và biểu tượng",
        "zh-CN": "链接和图标",
        "zh-TW": "連結與圖示"
      },
      "default": "#000000"
    },
    {
      "type": "header",
      "content": {
        "cs": "Průhledné záhlaví",
        "da": "Gennemsigtigt sidehoved",
        "de": "Transparenter Header",
        "en": "Transparent header",
        "es": "Encabezado transparente",
        "fi": "Läpinäkyvä ylätunniste",
        "fr": "En-tête transparent",
        "it": "Header trasparente",
        "ja": "透過ヘッダー",
        "ko": "투명 헤더",
        "nb": "Gjennomsiktig overskrift",
        "nl": "Transparante koptekst",
        "pl": "Nagłówek transparentny",
        "pt-BR": "Cabeçalho transparente",
        "pt-PT": "Cabeçalho transparente",
        "sv": "Genomskinlig rubrik",
        "th": "ส่วนหัวโปร่งใส",
        "tr": "Şeffaf üstbilgi",
        "vi": "Đầu trang trong suốt",
        "zh-CN": "透明标题",
        "zh-TW": "透明標頭"
      }
    },
    {
      "type": "checkbox",
      "id": "transparent_header_enable",
      "label": {
        "cs": "Zapnout průhledné záhlaví na domovské stránce",
        "da": "Aktivér gennemsigtigt sidehoved på startsiden",
        "de": "Transparenten Header auf der Startseite aktivieren",
        "en": "Enable transparent header on the homepage",
        "es": "Habilitar encabezado transparente en la página de inicio",
        "fi": "Ota läpinäkyvä ylätunniste käyttöön kotisivulla",
        "fr": "Activer l'en-tête transparent de la page d'accueil",
        "it": "Abilita header trasparente nella home page",
        "ja": "ホームページの透過ヘッダーを有効にする",
        "ko": "홈 페이지에서 투명 헤더를 사용합니다.",
        "nb": "Aktiver gjennomsiktig overskrift på hjemmesiden",
        "nl": "Transparante koptekst inschakelen op de startpagina",
        "pl": "Włącz nagłówek transparentny na stronie głównej",
        "pt-BR": "Habilitar cabeçalho transparente na página inicial.",
        "pt-PT": "Ativar cabeçalho transparente na página inicial",
        "sv": "Klicka på aktivera transparent rubrik på startsidan.",
        "th": "เปิดใช้ส่วนหัวแบบโปร่งใสในหน้าแรก",
        "tr": "Ana sayfada şeffaf üstbilgiyi etkinleştir",
        "vi": "Bật đầu trang trong suốt trên trang chủ",
        "zh-CN": "在主页上启用透明标题",
        "zh-TW": "啟用首頁上的透明標頭"
      },
      "info": {
        "cs": "Platí pro případy, kdy horní sekce představuje prezentaci.",
        "da": "Gælder, når det øverste afsnit er et diasshow.",
        "de": "Anwendbar, wenn der obere Abschnitt eine Slideshow ist.",
        "en": "Applicable when the top section is a slideshow.",
        "es": "Aplica cuando la sección superior es una presentación de diapositivas.",
        "fi": "Sovelletaan, kun yläosa on diaesitys.",
        "fr": "Applicable lorsque la partie supérieure est un diaporama.",
        "it": "Disponibile quando la sezione superiore è una presentazione.",
        "ja": "上部のセクションがスライドショーの場合に適用されます。",
        "ko": "상단 섹션이 슬라이드 쇼인 경우 적용 가능합니다.",
        "nb": "Gjelder når toppseksjonen er en lysbildefremvisning.",
        "nl": "Van toepassing wanneer het bovenste gedeelte een diavoorstelling is.",
        "pl": "Ma zastosowanie, gdy górna sekcja jest pokazem slajdów.",
        "pt-BR": "Aplicável quando a seção superior é uma apresentação de slides.",
        "pt-PT": "Aplicável quando a secção superior é uma apresentação de diapositivos.",
        "sv": "Tillämplig när det övre avsnittet är ett bildspel.",
        "th": "สามารถใช้งานได้เมื่อส่วนบนเป็นสไลด์โชว์",
        "tr": "Üst bölüm slayt gösterisi olduğunda geçerlidir.",
        "vi": "Áp dụng khi có bản trình chiếu ở phần trên cùng.",
        "zh-CN": "在顶部部分是幻灯片时适用。",
        "zh-TW": "可於頂端區段為輪播投影片時套用。"
      },
      "default": true
    },
    {
      "type": "image_picker",
      "id": "transparent_logo",
      "label": {
        "cs": "Průhledné logo",
        "da": "Gennemsigtigt logo",
        "de": "Transparentes Logo",
        "en": "Transparent logo",
        "es": "Logo transparente",
        "fi": "Läpinäkyvä logo",
        "fr": "Logo transparent",
        "it": "Logo trasparente",
        "ja": "透明なロゴ",
        "ko": "투명 로고",
        "nb": "Gjennomsiktig logo",
        "nl": "Transparant logo",
        "pl": "Logo transparentne",
        "pt-BR": "Logo transparente",
        "pt-PT": "Logótipo transparente",
        "sv": "Transparent logotyp",
        "th": "โลโก้โปร่งใส",
        "tr": "Şeffaf logo",
        "vi": "Logo trong suốt",
        "zh-CN": "透明的 logo",
        "zh-TW": "透明商標"
      },
      "info": {
        "cs": "Zobrazí se v případě zapnutí průhledného záhlaví.",
        "da": "Vises, når det gennemsigtige sidehoved aktiveres.",
        "de": "Wird angezeigt, wenn ein transparenter Header aktiviert ist.",
        "en": "Displayed when transparent header is enabled.",
        "es": "Se muestra cuando el encabezado transparente está habilitado.",
        "fi": "Näytetään silloin, kun läpinäkyvä ylätunniste ei ole käytössä.",
        "fr": "Affiché lorsque l'en-tête transparent est activé.",
        "it": "Visualizzato quando l'header trasparente è abilitato.",
        "ja": "透明なヘッダーが有効になっている場合に表示されます。",
        "ko": "투명 헤더가 사용 가능한 경우 표시됩니다.",
        "nb": "Vises når gjennomsiktig topptekst er aktivert.",
        "nl": "Weergegeven wanneer transparante kop is ingeschakeld.",
        "pl": "Wyświetlane przy włączonym nagłówku transparentnym.",
        "pt-BR": "Exibido quando o cabeçalho transparente está habilitado.",
        "pt-PT": "Apresentado quando o cabeçalho transparente é ativado.",
        "sv": "Visas när transparent rubrik är aktiverad.",
        "th": "จะแสดงเมื่อมีการใช้ส่วนหัวแบบโปร่งใส",
        "tr": "Şeffaf üstbilgi etkin olduğunda görüntülenir.",
        "vi": "Hiển thị khi bật đầu trang trong suốt.",
        "zh-CN": "在启用透明标题时显示。",
        "zh-TW": "在透明標頭啟用時顯示。"
      }
    },
    {
      "type": "color",
      "id": "transparent_header_color",
      "label": {
        "cs": "Odkazy a ikony průhledného záhlaví",
        "da": "Links og ikoner til gennemsigtigt sidehoved",
        "de": "Transparente Header-Links und -Symbole",
        "en": "Transparent header links and icons",
        "es": "Enlaces e íconos de encabezado transparentes",
        "fi": "Läpinäkyvän ylätunnisteen linkit ja kuvakkeet",
        "fr": "Liens et icônes d'en-tête transparents",
        "it": "Link e icone header trasparenti",
        "ja": "透明なヘッダーのリンクとアイコン",
        "ko": "투명 헤더 링크와 아이콘",
        "nb": "Gjennomsiktige topptekstkoblinger og ikoner",
        "nl": "Transparante koptekstkoppelingen en pictogrammen",
        "pl": "Transparentne linki i ikony nagłówka",
        "pt-BR": "Links e ícones de cabeçalho transparentes",
        "pt-PT": "Ligações e ícones de cabeçalho transparentes",
        "sv": "Transparenta rubriklänkar och ikoner",
        "th": "ลิงก์และไอคอนของส่วนหัวแบบโปร่งใส",
        "tr": "Şeffaf üstbilgi bağlantıları ve simgeleri",
        "vi": "Liên kết và biểu tượng đầu trang trong suốt",
        "zh-CN": "透明的标题链接和图标",
        "zh-TW": "透明標頭連結與圖示"
      },
      "default": "#ffffff"
    },
    {
      "type": "header",
      "content": "Navigation"
    },
    {
      "type": "select",
      "id": "search",
      "options": [
        {
          "value": "modal",
          "label": {
            "cs": "Modální okno",
            "da": "Modus",
            "de": "Modal",
            "en": "Modal",
            "es": "Modal",
            "fi": "Modaalinen",
            "fr": "Fenêtre modale",
            "it": "Modal",
            "ja": "モーダル",
            "ko": "모달",
            "nb": "Panel",
            "nl": "Modaal venster",
            "pl": "Tryb modalny",
            "pt-BR": "Modal",
            "pt-PT": "Modal",
            "sv": "Modal",
            "th": "โมดอล",
            "tr": "Mod",
            "vi": "Hộp tương tác",
            "zh-CN": "模式",
            "zh-TW": "互動視窗"
          }
        },
        {
          "value": "page",
          "label": {
            "cs": "Stránka",
            "da": "Side",
            "de": "Seite",
            "en": "Page",
            "es": "Página",
            "fi": "Sivu",
            "fr": "Page",
            "it": "Pagina",
            "ja": "ページ",
            "ko": "페이지",
            "nb": "Side",
            "nl": "Pagina",
            "pl": "Strona",
            "pt-BR": "Página",
            "pt-PT": "Página",
            "sv": "Sida",
            "th": "หน้า",
            "tr": "Sayfa",
            "vi": "Trang",
            "zh-CN": "页面",
            "zh-TW": "頁面"
          }
        },
        {
          "value": "none",
          "label": {
            "cs": "Žádné",
            "da": "Ingen",
            "de": "Keine",
            "en": "None",
            "es": "Ninguno",
            "fi": "Ei mitään",
            "fr": "Aucune",
            "it": "Nessuno",
            "ja": "なし",
            "ko": "없음",
            "nb": "Ingen",
            "nl": "Geen",
            "pl": "Brak",
            "pt-BR": "Nenhum",
            "pt-PT": "Nenhum",
            "sv": "Inga",
            "th": "ไม่มี",
            "tr": "Yok",
            "vi": "Không",
            "zh-CN": "无",
            "zh-TW": "無"
          }
        }
      ],
      "label": {
        "cs": "Typ vyhledávání",
        "da": "Søgetype",
        "de": "Suchtyp",
        "en": "Search type",
        "es": "Tipo de búsqueda",
        "fi": "Hakutyyppi",
        "fr": "Type de recherche",
        "it": "Tipo di ricerca",
        "ja": "検索タイプ",
        "ko": "검색 유형",
        "nb": "Søketype",
        "nl": "Zoektype",
        "pl": "Typ wyszukiwania",
        "pt-BR": "Tipo de pesquisa",
        "pt-PT": "Tipo de pesquisa",
        "sv": "Söktyp",
        "th": "ประเภทของการค้นหา",
        "tr": "Arama türü",
        "vi": "Kiểu tìm kiếm",
        "zh-CN": "搜索类型",
        "zh-TW": "搜尋類型"
      }
    },
    {
      "type": "link_list",
      "id": "main_menu_link_list",
      "label": {
        "cs": "Nabídka",
        "da": "Menu",
        "de": "Menü",
        "en": "Menu",
        "es": "Menú",
        "fi": "Valikko",
        "fr": "Menu",
        "it": "Menu",
        "ja": "メニュー",
        "ko": "메뉴",
        "nb": "Meny",
        "nl": "Menu",
        "pl": "Menu",
        "pt-BR": "Menu",
        "pt-PT": "Menu",
        "sv": "Meny",
        "th": "เมนู",
        "tr": "Menü",
        "vi": "Menu",
        "zh-CN": "菜单",
        "zh-TW": "選單"
      },
      "default": "main-menu",
      "info": {
        "cs": "Nabídka se sbalí do nabídkového tlačítka v případě, že odkazy jsou příliš dlouhé. [Další informace](https://help.shopify.com/manual/using-themes/themes-by-shopify/brooklyn#navigation-tips-tips-specific)",
        "da": "Menuen komprimeres til en menuknap, hvis linkene er for lange. [Få mere at vide](https://help.shopify.com/manual/using-themes/themes-by-shopify/brooklyn#navigation-tips-tips-specific)",
        "de": "Wenn Links zu lang sind, wird das Menü eingeklappt und als Menü-Schaltfläche angezeigt. [Mehr Informationen](https://help.shopify.com/manual/using-themes/themes-by-shopify/brooklyn#navigation-tips-tips-specific)",
        "en": "The menu will collapse into a menu button if links are too long. [Learn more](https://help.shopify.com/manual/using-themes/themes-by-shopify/brooklyn#navigation-tips-tips-specific)",
        "es": "El menú se contraerá en un botón de menú si los enlaces son demasiado largos. [Más información](https://help.shopify.com/manual/using-themes/themes-by-shopify/brooklyn#navigation-tips-tips-specific)",
        "fi": "Valikko kutistuu valikkopainikkeeksi, jos linkit ovat liian pitkiä. [Lisätietoja](https://help.shopify.com/manual/using-themes/themes-by-shopify/brooklyn#navigation-tips-tips-specific)",
        "fr": "Le menu sera réduit à un bouton de menu si les liens sont trop longs. [En savoir plus](https://help.shopify.com/manual/using-themes/themes-by-shopify/brooklyn#navigation-tips-tips-specific)",
        "it": "Il menu si ridurrà a un pulsante menu se i link sono troppo lunghi. [Maggiori informazioni](https://help.shopify.com/manual/using-themes/themes-by-shopify/brooklyn#navigation-tips-tips-specific)",
        "ja": "リンクが長すぎる場合、メニューがメニューボタンに折りたたまれます。[詳しくはこちら](https://help.shopify.com/manual/using-themes/themes-by-shopify/brooklyn#navigation-tips-tips-specific)",
        "ko": "링크가 너무 길면 메뉴가 메뉴 버튼으로 축소됩니다. [자세히 알아보기](https://help.shopify.com/manual/using-themes/themes-by-shopify/brooklyn#navigation-tips-tips-specific)",
        "nb": "Menyen slås sammen til en menyknapp hvis koblingene er for lange. [Finn ut mer](https://help.shopify.com/manual/using-themes/themes-by-shopify/brooklyn#navigation-tips-tips-specific)",
        "nl": "Het menu zal inklappen tot een menuknop als de links te lang zijn. [Meer informatie](https://help.shopify.com/manual/using-themes/themes-by-shopify/brooklyn#navigation-tips-tips-specific)",
        "pl": "Menu zwinie się do postaci przycisku Menu, jeśli linki będą zbyt długie. [Dowiedz się więcej](https://help.shopify.com/manual/using-themes/themes-by-shopify/brooklyn#navigation-tips-tips-specific)",
        "pt-BR": "O menu ficará oculto em um botão de menu se os links forem longos demais. [Saiba mais](https://help.shopify.com/manual/using-themes/themes-by-shopify/brooklyn#navigation-tips-tips-specific)",
        "pt-PT": "O menu será fechado num botão de menu se as ligações forem demasiado compridas. [Saiba mais](https://help.shopify.com/manual/using-themes/themes-by-shopify/brooklyn#navigation-tips-tips-specific)",
        "sv": "Menyn kommer att kollapsa till en menyknapp om länkarna är för långa. [Läs mer](https://help.shopify.com/manual/using-themes/themes-by-shopify/brooklyn#navigation-tips-tips-specific)",
        "th": "เมนูนี้จะย่อลงเป็นปุ่มเมนูในกรณีที่ลิงก์ยาวเกินไป [ดูข้อมูลเพิ่มเติม](https://help.shopify.com/manual/using-themes/themes-by-shopify/brooklyn#navigation-tips-tips-specific)",
        "tr": "Bağlantılar çok uzun olduğunda menü daralarak menü düğmesine dönüşür. [Daha fazla bilgi edinin](https://help.shopify.com/manual/using-themes/themes-by-shopify/brooklyn#navigation-tips-tips-specific)",
        "vi": "Menu sẽ được thu nhỏ thành nút menu nếu liên kết quá dài. [Tìm hiểu thêm](https://help.shopify.com/manual/using-themes/themes-by-shopify/brooklyn#navigation-tips-tips-specific)",
        "zh-CN": "如果链接过长，菜单将折叠成菜单按钮。[了解详细信息](https://help.shopify.com/manual/using-themes/themes-by-shopify/brooklyn#navigation-tips-tips-specific)",
        "zh-TW": "如果連結太長，選單會收合為選單按鈕。[深入瞭解](https://help.shopify.com/manual/using-themes/themes-by-shopify/brooklyn#navigation-tips-tips-specific)"
      }
    },
    {
      "type": "link_list",
      "id": "drawer_bottom_link_list",
      "label": {
        "cs": "Vedlejší nabídka v postranní liště",
        "da": "Sekundær sidebjælkemenu",
        "de": "Zusätzliches Menü",
        "en": "Secondary sidebar menu",
        "es": "Menú adicional",
        "fi": "Sivupalkkivalikko",
        "fr": "Menu supplémentaire",
        "it": "Menu aggiuntivo",
        "ja": "追加メニュー",
        "ko": "보조 사이드바 메뉴",
        "nb": "Sekundær meny i sidefeltet",
        "nl": "Secundair zijbalkmenu",
        "pl": "Dodatkowe menu paska bocznego",
        "pt-BR": "Menu adicional",
        "pt-PT": "Menu lateral secundário",
        "sv": "Sekundär sidofältsmeny",
        "th": "เมนูแถบด้านข้างรอง",
        "tr": "İkincil kenar çubuğu menüsü",
        "vi": "Menu thanh bên thứ cấp",
        "zh-CN": "辅助侧边栏菜单",
        "zh-TW": "次要側邊欄選單"
      },
      "default": "footer"
    },
    {
      "type": "checkbox",
      "id": "drawer_search_enable",
      "label": {
        "cs": "Povolit vyhledávání",
        "da": "Aktivér søgning",
        "de": "Suche aktivieren",
        "en": "Enable search",
        "es": "Habilitar búsqueda",
        "fi": "Ota hakutoiminto käyttöön",
        "fr": "Activer la recherche",
        "it": "Abilita ricerca",
        "ja": "検索を有効にする",
        "ko": "검색 활성화",
        "nb": "Aktiver søk",
        "nl": "Zoeken inschakelen",
        "pl": "Włącz wyszukiwanie",
        "pt-BR": "Habilitar pesquisa",
        "pt-PT": "Ativar pesquisa",
        "sv": "Aktivera sökning",
        "th": "เปิดใช้การค้นหา",
        "tr": "Arama özelliğini etkinleştir",
        "vi": "Bật tìm kiếm",
        "zh-CN": "启用搜索",
        "zh-TW": "啟用搜索"
      }
    },
    {
      "type": "header",
      "content": {
        "cs": "Panel oznámení",
        "da": "Meddelelseslinje",
        "de": "Ankündigungsleiste",
        "en": "Announcement bar",
        "es": "Barra de anuncios",
        "fi": "Ilmoituspalkki",
        "fr": "Barre d'annonces",
        "it": "Barra degli annunci",
        "ja": "告知バー",
        "ko": "공지 표시줄",
        "nb": "Kunngjøringslinje",
        "nl": "Aankondigingsbalk",
        "pl": "Pasek ogłoszeń",
        "pt-BR": "Barra de avisos",
        "pt-PT": "Barra de comunicado",
        "sv": "Meddelandefält",
        "th": "แถบประกาศ",
        "tr": "Duyuru çubuğu",
        "vi": "Thanh thông báo",
        "zh-CN": "公告栏",
        "zh-TW": "公告列"
      }
    },
    {
      "type": "checkbox",
      "id": "show_announcement",
      "label": {
        "cs": "Zobrazit oznámení",
        "da": "Vis meddelelse",
        "de": "Ankündigung anzeigen",
        "en": "Show announcement",
        "es": "Mostrar anuncio",
        "fi": "Näytä ilmoitus",
        "fr": "Afficher l'annonce",
        "it": "Mostra annuncio",
        "ja": "告知を表示する",
        "ko": "공지 표시",
        "nb": "Vis kunngjøring",
        "nl": "Aankondiging weergeven",
        "pl": "Pokaż ogłoszenie",
        "pt-BR": "Exibir comunicado",
        "pt-PT": "Mostrar comunicado",
        "sv": "Visa tillkännagivande",
        "th": "แสดงประกาศ",
        "tr": "Duyuruyu göster",
        "vi": "Hiển thị thông báo",
        "zh-CN": "显示公告",
        "zh-TW": "顯示公告"
      },
      "default": false
    },
    {
      "type": "checkbox",
      "id": "home_page_only",
      "label": {
        "cs": "Jen domovská stránka",
        "da": "Kun startside",
        "de": "Nur Startseite",
        "en": "Home page only",
        "es": "Solo página de inicio",
        "fi": "Vain etusivu",
        "fr": "Page d'accueil uniquement",
        "it": "Solo home page",
        "ja": "ホームページのみ",
        "ko": "홈페이지만",
        "nb": "Kun på startsiden",
        "nl": "Alleen homepage",
        "pl": "Tylko strona główna",
        "pt-BR": "Apenas na página inicial",
        "pt-PT": "Apenas a página inicial",
        "sv": "Endast hemsida",
        "th": "หน้าแรกเท่านั้น",
        "tr": "Yalnızca ana sayfa",
        "vi": "Chỉ trang chủ",
        "zh-CN": "仅主页",
        "zh-TW": "僅限首頁"
      },
      "default": true
    },
    {
      "type": "text",
      "id": "text",
      "label": {
        "cs": "Text",
        "da": "Tekst",
        "de": "Text",
        "en": "Text",
        "es": "texto",
        "fi": "Teksti",
        "fr": "Texte",
        "it": "Testo",
        "ja": "テキスト",
        "ko": "텍스트",
        "nb": "Tekst",
        "nl": "Tekst",
        "pl": "Tekst",
        "pt-BR": "Texto",
        "pt-PT": "Texto",
        "sv": "Text",
        "th": "ข้อความ",
        "tr": "Metin",
        "vi": "Văn bản",
        "zh-CN": "文本",
        "zh-TW": "文字"
      },
      "default": {
        "cs": "Tady můžete zadat oznámení",
        "da": "Meddel noget her",
        "de": "Hier Ankündigung platzieren",
        "en": "Announce something here",
        "es": "Anuncia algo aquí",
        "fi": "Ilmoita jotakin tässä",
        "fr": "Annoncer quelque chose ici",
        "it": "Annuncia qualcosa qui",
        "ja": "ここで告知してください",
        "ko": "여기에 공지하십시오",
        "nb": "Kunngjør noe her",
        "nl": "Kondig hier iets aan",
        "pl": "Ogłoś coś tutaj",
        "pt-BR": "Anuncie algo aqui",
        "pt-PT": "Anunciar algo aqui",
        "sv": "Meddela något här",
        "th": "ประกาศข้อความที่นี่",
        "tr": "Buraya bir duyuru ekleyin",
        "vi": "Thông báo điều gì đó tại đây",
        "zh-CN": "在此处进行公告",
        "zh-TW": "在此公告資訊"
      }
    },
    {
      "type": "url",
      "id": "link",
      "label": {
        "cs": "Odkaz",
        "da": "Link",
        "de": "Link",
        "en": "Link",
        "es": "Enlace",
        "fi": "Linkki",
        "fr": "Lien",
        "it": "Link",
        "ja": "リンク",
        "ko": "링크",
        "nb": "Kobling",
        "nl": "Link",
        "pl": "Link",
        "pt-BR": "Link",
        "pt-PT": "Ligação",
        "sv": "Länk",
        "th": "ลิงก์",
        "tr": "Bağlantı",
        "vi": "Liên kết",
        "zh-CN": "链接",
        "zh-TW": "連結"
      }
    },
    {
      "type": "color",
      "id": "color_bg",
      "label": {
        "cs": "Panel",
        "da": "Bjælke",
        "de": "Leiste",
        "en": "Bar",
        "es": "Barra",
        "fi": "Palkki",
        "fr": "Barre",
        "it": "Barra",
        "ja": "バー",
        "ko": "바",
        "nb": "Felt",
        "nl": "Balk",
        "pl": "Pasek",
        "pt-BR": "Barra",
        "pt-PT": "Barra",
        "sv": "Fält",
        "th": "แถบ",
        "tr": "Çubuk",
        "vi": "Thanh",
        "zh-CN": "栏",
        "zh-TW": "橫條"
      },
      "default": "#1c1d1d"
    },
    {
      "type": "color",
      "id": "color_text",
      "label": {
        "cs": "Text",
        "da": "Tekst",
        "de": "Text",
        "en": "Text",
        "es": "texto",
        "fi": "Teksti",
        "fr": "Texte",
        "it": "Testo",
        "ja": "テキスト",
        "ko": "텍스트",
        "nb": "Tekst",
        "nl": "Tekst",
        "pl": "Tekst",
        "pt-BR": "Texto",
        "pt-PT": "Texto",
        "sv": "Text",
        "th": "ข้อความ",
        "tr": "Metin",
        "vi": "Văn bản",
        "zh-CN": "文本",
        "zh-TW": "文字"
      },
      "default": "#ffffff"
    }
  ]
}
{% endschema %}