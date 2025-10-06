const storedTheme = localStorage.getItem('theme')
const getPreferredTheme = () => {
    if(!DARK_MODE_SWITCH){
        if(DEFAULT_THEME_MODE == 'auto'){
            return window.matchMedia('(prefers-color-scheme: light)').matches ? 'light' : 'dark';
        } else {
            return DEFAULT_THEME_MODE;
        }
    }
    if (storedTheme) {
        return storedTheme
    }
    if(DEFAULT_THEME_MODE == 'auto'){
        return window.matchMedia('(prefers-color-scheme: light)').matches ? 'light' : 'dark';
    } else {
        return DEFAULT_THEME_MODE;
    }
}

const setTheme = function (theme) {
    if (theme === 'auto') {
        if(window.matchMedia('(prefers-color-scheme: dark)').matches) {
            document.documentElement.setAttribute('data-bs-theme', 'dark')
            localStorage.setItem('theme', 'dark')
        }else {
            document.documentElement.setAttribute('data-bs-theme', 'light')
            localStorage.setItem('theme', 'light')
        }
    } else {
        document.documentElement.setAttribute('data-bs-theme', theme)
        localStorage.setItem('theme', theme)
    }
}

setTheme(getPreferredTheme())

window.addEventListener('DOMContentLoaded', () => {
    var el = document.querySelector('.theme-icon-active');
    if(el != 'undefined' && el != null) {
        const showActiveTheme = theme => {
            const activeThemeIcon = document.querySelector('.theme-icon-active use')
            const btnToActive = document.querySelector(`[data-bs-theme-value="${theme}"]`)
            const svgOfActiveBtn = btnToActive.querySelector('.mode-switch use').getAttribute('href')

            document.querySelectorAll('[data-bs-theme-value]').forEach(element => {
                element.classList.remove('active')
            })

            btnToActive.classList.add('active')
            activeThemeIcon.setAttribute('href', svgOfActiveBtn)
        }

        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
            if (storedTheme !== 'light' || storedTheme !== 'dark') {
                setTheme(getPreferredTheme())
            }
        })

        showActiveTheme(getPreferredTheme())

        document.querySelectorAll('[data-bs-theme-value]')
            .forEach(toggle => {
                toggle.addEventListener('click', () => {
                    const theme = toggle.getAttribute('data-bs-theme-value')
                    setTheme(theme)
                    showActiveTheme(theme)
                })
            })

    }
});

$(document).ready(function() {
    $('#latest-project-mobile-menu .dropdown-item').on('click', function(e) {
        // Prevent the default behavior (navigation)
        e.preventDefault();

        // Get the target tab content ID from the data-bs-target attribute
        var targetTab = $(this).data('bs-target'); // e.g., #discover_buy

        // Remove 'active' and 'show' classes from all tab content inside the section
        $('#latest-project-mobile-menu .tab-pane').removeClass('active show');

        // Add 'active' and 'show' classes to the selected tab content
        $(targetTab).addClass('active show');

        // Remove 'active' class from all tab links inside the section
        $('#latest-project-mobile-menu .nav-link').removeClass('active');

        // Add 'active' class to the clicked tab link
        var targetTabLink = $(this).closest('li').find('.nav-link'); // Get the corresponding tab link
        targetTabLink.addClass('active');

        // Update the dropdown label text to reflect the selected option
        var labelText = $(this).text();
        $('#latest-project-mobile-menu .dropdown-toggle-label').text(labelText);
    });
});