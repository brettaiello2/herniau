(function($) { "use strict";

document.addEventListener('DOMContentLoaded', function () {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
});

jQuery(document).ready(function($) {

$('body').addClass('loaded');

flyoutMenuToggle();
flyoutMenuSubMenus();
externalLinks();
contentAjax();
loadHeroBackground();
accountMenu();
addNavPills();


});

function flyoutMenuToggle() {
    const $navToggle = $(".nav-toggle");
    const $flyoutMenu = $("nav.flyout-menu");

    // Toggle menu on button click
    $(".nav-toggle, .flyout-menu .close-btn").on("click", function (e) {
        e.stopPropagation(); // Prevent the click from bubbling up
        $navToggle.toggleClass("active");
        $flyoutMenu.toggleClass("active");
    });

    // Close menu if clicking outside
    $(document).on("click", function (e) {
        if (!$flyoutMenu.is(e.target) && $flyoutMenu.has(e.target).length === 0 &&
            !$navToggle.is(e.target) && $navToggle.has(e.target).length === 0) {
            // Remove active classes
            $navToggle.removeClass("active");
            $flyoutMenu.removeClass("active");
        }
    });
}

function flyoutMenuSubMenus() {


  const menuItems = document.querySelectorAll(".flyout-menu .menu > li");

  menuItems.forEach((item) => {
    const subMenu = item.querySelector(".sub-menu");

    if (subMenu) {
      // Create toggle button
      const toggleBtn = document.createElement("button");
      toggleBtn.classList.add("submenu-toggle");
      toggleBtn.setAttribute("aria-label", "Toggle submenu");
      toggleBtn.innerHTML = `
        <svg class="caret-icon" width="16" height="16" viewBox="0 0 24 24">
          <path d="M6 9l6 6 6-6" fill="none" stroke="currentColor" stroke-width="2"/>
        </svg>
      `;

      // Append toggle button after the anchor link
      const link = item.querySelector("a");
      link.after(toggleBtn);

      // Toggle logic
      toggleBtn.addEventListener("click", function () {
        subMenu.classList.toggle("active");
        this.classList.toggle("open");
        // Swap the icon direction
        this.querySelector("path").setAttribute(
          "d",
          subMenu.classList.contains("active")
            ? "M6 15l6-6 6 6"  // up
            : "M6 9l6 6 6-6"  // down
        );
      });
    }
  });


}


function externalLinks() {

  const links = document.querySelectorAll('a[href^="http"]');
  links.forEach(function (link) {
    // Only apply to external links
    if (link.hostname !== window.location.hostname) {
      link.setAttribute('target', '_blank');
      link.setAttribute('rel', 'noopener noreferrer');
    }
  });

}

function loadHeroBackground() {

    const imageUrl = document.getElementById('background-image')?.value;

    if (imageUrl) {
      const bg = document.createElement('div');
      bg.className = 'background-image';
      bg.style.backgroundImage = `url('${imageUrl}')`;

      const heroContainer = document.querySelector('.page-hero');

      if (heroContainer) {
        // Calculate total height including padding
        const computedStyle = window.getComputedStyle(heroContainer);
        const height = heroContainer.offsetHeight;
        const paddingTop = parseFloat(computedStyle.paddingTop);
        const paddingBottom = parseFloat(computedStyle.paddingBottom);
        const totalHeight = height + paddingTop + paddingBottom;

        bg.style.height = `${totalHeight}px`;

        // Insert background before other content
        heroContainer.insertBefore(bg, heroContainer.firstChild);

        // Trigger fade-in after a tiny delay to allow initial render
        requestAnimationFrame(() => {
          bg.classList.add('visible');
        });
      }
    }

}



function accountMenu() {
    $(".account-menu .trigger").on("click", function(e) {
        e.stopPropagation();
        $(this).toggleClass("active");
        $(".account-menu nav").toggleClass("active");
    });

    $(document).on("click", function(e) {
        if (!$(e.target).closest(".account-menu").length) {
            $(".account-menu .trigger").removeClass("active");
            $(".account-menu nav").removeClass("active");
        }
    });
}



function addNavPills() {
  // Check if WordPress output the logged-in body class
  const isLoggedIn = document.body.classList.contains('logged-in');

  // Define the menu items
  const items = [
    { text: 'Home', href: '/', activeOn: ['page-id-1663'] },
    { 
      text: 'Courses', 
      href: isLoggedIn ? '/my-courses' : '/hernia-a-to-z-fundamentals/', // <-- Swaps based on body class
      activeOn: ['page-id-43868'] 
    },
    { text: 'Upcoming Events', href: '/events', activeOn: ['page-id-994'] },
    { text: 'Videos', href: '/videos', activeOn: ['page-id-43873'] },
    { text: 'Lectures', href: '/lectures', activeOn: ['page-id-12106'] },  
    { text: 'IHS', href: '/ihs', activeOn: ['page-id-44114'] },
    { text: 'Podcasts', href: '/podcast', activeOn: ['page-id-44428'] }
  ];

  // Create the main nav container
  const navDiv = document.createElement('div');
  navDiv.className = 'nav-pills alt';

  const ul = document.createElement('ul');

  // Loop through items and build each <li>
  items.forEach(item => {
    const li = document.createElement('li');

    // Check if any of the "activeOn" classes are present on <body>
    const isActive = item.activeOn.some(cls => document.body.classList.contains(cls));
    if (isActive) {
      li.classList.add('active');
    }

    const a = document.createElement('a');
    a.href = item.href;
    a.textContent = item.text;

    li.appendChild(a);
    ul.appendChild(li);
  });

  navDiv.appendChild(ul);

  const wrapperDiv = document.createElement('div');
  wrapperDiv.className = 'sub-nav-menu';

  wrapperDiv.appendChild(navDiv);

  // Prepend to .entry-content .wp-block-group.container
  const entryContent = document.querySelector('.entry-content .wp-block-group.container');
  if (entryContent) {
    entryContent.prepend(wrapperDiv);
  }
}


function contentAjax() {

    jQuery(document).on('click', '.load-more', function() {
        var button = jQuery(this);

        var page   = parseInt(button.attr('data-current-page')) + 1;
        var max    = parseInt(button.attr('data-max-pages'));
        var type   = button.data('post-type');
        var per    = button.data('posts-per-page');
        var tax    = button.data('taxonomy');
        var term   = button.data('term');
        var sortby = button.data('sort'); 

        jQuery.ajax({
            url: ajax_loadmore_params.ajaxurl,
            type: 'POST',
            data: {
                action: 'loadmore_posts',
                page: page,
                post_type: type,
                posts_per_page: per,
                taxonomy: tax,
                term: term,
                sort_by: sortby 
            },
            beforeSend: function() {
                button.text('Loading...');
            },
            success: function(data) {
                if (data) {
                    button.text('Load More');
                    button.attr('data-current-page', page);
                    jQuery('.grid-posts').append(data);

                    if (page >= max) {
                        button.remove();
                    }
                } else {
                    button.remove();
                }
            }
        });
    });

}



})(jQuery);


