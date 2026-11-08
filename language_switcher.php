<div class="site-language-switcher" data-current-language="<?php echo htmlspecialchars($_GET['lang'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
    <button class="site-language-toggle" type="button" aria-expanded="false" aria-controls="site-language-options">
        <span aria-hidden="true">&#127760;</span>
        <span class="site-language-current">English</span>
        <span aria-hidden="true">&#9662;</span>
    </button>
    <div class="site-language-options" id="site-language-options" hidden>
        <button type="button" data-language="en">English</button>
        <button type="button" data-language="la">ລາວ</button>
        <button type="button" data-language="ko">한국어</button>
        <button type="button" data-language="zh">中文</button>
    </div>
</div>

<style>
    .site-language-switcher {
        position: relative;
        flex: 0 0 auto;
        font-family: inherit;
    }

    .site-header .site-language-switcher {
        margin: 0;
    }

    .site-language-toggle {
        display: flex;
        align-items: center;
        gap: 8px;
        min-height: 40px;
        padding: 8px 13px;
        border: 1px solid #d5e0e9;
        border-radius: 22px;
        color: #082d49;
        background: #fff;
        box-shadow: 0 3px 14px rgba(0, 0, 0, .13);
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
    }

    .site-language-options {
        position: absolute;
        top: calc(100% + 7px);
        right: 0;
        min-width: 142px;
        padding: 6px;
        border: 1px solid #e1e7ec;
        border-radius: 12px;
        background: #fff;
        box-shadow: 0 8px 24px rgba(0, 0, 0, .16);
    }

    .site-language-options[hidden] {
        display: none;
    }

    .site-language-options button {
        display: block;
        width: 100%;
        padding: 9px 11px;
        border: 0;
        border-radius: 7px;
        color: #243746;
        background: transparent;
        text-align: left;
        font-size: 14px;
        cursor: pointer;
    }

    .site-language-options button:hover,
    .site-language-options button[aria-current="true"] {
        color: #082d49;
        background: #edf3f7;
    }

    @media (max-width: 575.98px) {
        .site-language-toggle {
            min-height: 36px;
            padding: 6px 10px;
            font-size: 12px;
        }
    }
</style>

<script src="site_translations.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
(function() {
    const labels = {
        en: 'English',
        la: 'ລາວ',
        ko: '한국어',
        zh: '中文'
    };
    const navLabels = {
        en: ['HOME', 'ABOUT IFL', 'PROGRAMS', 'Activities', 'NEWS', 'RESOURCES'],
        la: ['ໜ້າຫຼັກ', 'ກ່ຽວກັບ', 'ຫຼັກສູດ', 'ກິດຈະກຳ', 'ຂ່າວສານ', 'ເອກະສານ'],
        ko: ['홈', '학교 소개', '교육 과정', '활동', '소식', '자료실'],
        zh: ['首页', '关于我们', '课程', '活动', '新闻', '资料']
    };
    const headerLabels = {
        en: { apply: 'Apply Now', login: 'Staff Login', logout: 'Logout' },
        la: { apply: 'ສະໝັກຮຽນ', login: 'ເຂົ້າລະບົບ', logout: 'ອອກຈາກລະບົບ' },
        ko: { apply: '지원하기', login: '직원 로그인', logout: '로그아웃' },
        zh: { apply: '立即申请', login: '员工登录', logout: '退出登录' }
    };
    const controlLabels = {
        en: ['Toggle navigation'],
        la: ['ສະຫຼັບເມນູນຳທາງ'],
        ko: ['내비게이션 메뉴 전환'],
        zh: ['切换导航菜单']
    };
    const switcher = document.querySelector('.site-language-switcher');
    if (!switcher) return;

    const currentUrl = new URL(window.location.href);
    const queryLanguage = currentUrl.searchParams.get('lang');
    const savedLanguage = window.localStorage.getItem('site-language');
    const validLanguages = ['en', 'la', 'ko', 'zh'];
    let activeLanguage = validLanguages.includes(queryLanguage)
        ? queryLanguage
        : (validLanguages.includes(savedLanguage) ? savedLanguage : 'en');

    function translateElementAttributes(element, language) {
        ['alt', 'title', 'placeholder', 'aria-label', 'data-title', 'data-desc', 'content', 'value'].forEach(function(attribute) {
            const value = element.getAttribute(attribute);
            if (!value) return;
            const key = value.replace(/\s+/g, ' ').trim();
            const translation = window.LOGOS_TRANSLATIONS[key];
            if (translation && translation[language]) {
                element.setAttribute(attribute, translation[language]);
            }
        });
    }

    function translatePage(language) {
        if (!document.body.classList.contains('site-content-page')) return;

        const walker = document.createTreeWalker(document.body, NodeFilter.SHOW_TEXT, {
            acceptNode: function(node) {
                if (!node.nodeValue.trim()) return NodeFilter.FILTER_REJECT;
                const parent = node.parentElement;
                if (!parent || parent.closest('script, style, noscript, svg, .site-header, .site-language-switcher, [data-no-translate]')) {
                    return NodeFilter.FILTER_REJECT;
                }
                return NodeFilter.FILTER_ACCEPT;
            }
        });
        const textNodes = [];
        while (walker.nextNode()) textNodes.push(walker.currentNode);

        textNodes.forEach(function(node) {
            const original = node.nodeValue;
            const key = original.replace(/\s+/g, ' ').trim();
            const translation = window.LOGOS_TRANSLATIONS[key];
            if (!translation || !translation[language]) return;

            const leadingSpace = original.match(/^\s*/)[0];
            const trailingSpace = original.match(/\s*$/)[0];
            node.nodeValue = leadingSpace + translation[language] + trailingSpace;
        });

        document.querySelectorAll('body.site-content-page *').forEach(function(element) {
            translateElementAttributes(element, language);
        });

        const titleKey = document.title.replace(/\s+/g, ' ').trim();
        const titleTranslation = window.LOGOS_TRANSLATIONS[titleKey];
        if (titleTranslation && titleTranslation[language]) {
            document.title = titleTranslation[language];
        }
    }

    function applyLanguage(language) {
        activeLanguage = language;
        window.localStorage.setItem('site-language', language);

        const toggle = switcher.querySelector('.site-language-toggle');
        switcher.querySelector('.site-language-current').textContent = labels[language];
        switcher.querySelectorAll('[data-language]').forEach(function(option) {
            option.setAttribute('aria-current', String(option.dataset.language === language));
        });

        const navItems = document.querySelectorAll('.custom_nav-container .navbar-nav .nav-item');
        navItems.forEach(function(item, index) {
            const link = item.querySelector('.nav-link');
            if (!link || !navLabels[language][index]) return;
            const icon = link.querySelector('i');
            link.textContent = navLabels[language][index];
            if (icon) link.appendChild(icon);
        });

        document.querySelectorAll('[data-label]').forEach(function(element) {
            const label = headerLabels[language][element.dataset.label];
            if (label) element.textContent = label;
        });
        document.querySelectorAll('.site-header-toggle').forEach(function(element) {
            element.setAttribute('aria-label', controlLabels[language][0]);
        });

        document.documentElement.lang = language;
        translatePage(language);
        document.querySelectorAll('a[href]').forEach(function(anchor) {
            try {
                const url = new URL(anchor.href, window.location.href);
                if (url.origin !== window.location.origin || !url.pathname.toLowerCase().endsWith('.php')) return;
                url.searchParams.set('lang', language);
                anchor.href = url.href;
            } catch (error) {
                console.error('Unable to update a language-aware link.', error);
            }
        });
    }

    const toggle = switcher.querySelector('.site-language-toggle');
    const options = switcher.querySelector('.site-language-options');
    toggle.addEventListener('click', function() {
        const isOpen = toggle.getAttribute('aria-expanded') === 'true';
        toggle.setAttribute('aria-expanded', String(!isOpen));
        options.hidden = isOpen;
    });

    switcher.querySelectorAll('[data-language]').forEach(function(option) {
        option.addEventListener('click', function() {
            const language = option.dataset.language;
            window.localStorage.setItem('site-language', language);
            const destination = new URL(window.location.href);
            destination.searchParams.set('lang', language);
            window.location.assign(destination.href);
        });
    });

    document.addEventListener('click', function(event) {
        if (!switcher.contains(event.target)) {
            toggle.setAttribute('aria-expanded', 'false');
            options.hidden = true;
        }
    });

    applyLanguage(activeLanguage);
})();
});
</script>
