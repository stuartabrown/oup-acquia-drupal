(function($){
  $.fn.initFooterMenuAccordion = function(){

    function handleMenuAccordion(){
      if (Foundation.MediaQuery.is('small only')) {
        new Foundation.AccordionMenu($('.menu_group.custom-block'), {});
      }else{
        try {
          $('.menu_group.custom-block').foundation('_destroy');
        }catch(e){}
      }
    }
    handleMenuAccordion();
    $(window).on('changed.zf.mediaquery', handleMenuAccordion);
  }
  $.fn.initOverlayPopup = function(){
    this.on('click', 'a.basic_image_block-popup', function(e){
      e.preventDefault();
      $('#overlay-popup').addClass('active');
      $('#overlay-main-content-landing').html('');
      if($(this).children('img').length > 0){
        var newImg = $(this).children('img').clone();
        $('#overlay-main-content-landing').append(newImg);
      }
    });
    this.on('click', '#overlay-close-button', function(e){
      e.preventDefault();
      $('#overlay-popup').removeClass('active');
    });
  }
  $.fn.initFilterPopup = function(){
    return this.each(function(index, element){
      if(typeof $(element).data('target') !== 'undefined'){
        var $target = $('#' + $(element).data('target'));
        var $filtertarget = $('#' + $(element).data('filtertarget'));
        if($filtertarget.length > 0){
          $(element).text($(element).data('targethasfilters')).addClass('has-filters');
        }
        if($target.length > 0){
          $(element).on('click', function(e){
            e.preventDefault();
            $target.toggleClass('active');
            if($target.is('.active')){
              if(typeof $(element).data('targettitle') !== 'undefined'){
                $target.find('[data-targettitle]').text($(element).data('targettitle'));
              }
            }
          });
          var $popupClose = $target.find('[data-popupclose]');
          if($popupClose.length > 0) {
            $popupClose.on('click', function (e) {
              e.preventDefault();
              $target.removeClass('active');
            });
          }
          var $applyFilter = $target.find('.past_campaign_popup__apply_filter');
          if($applyFilter.length > 0) {
            $applyFilter.on('click', function (e) {
              e.preventDefault();
              $target.removeClass('active');
            });
          }
          var $accordion = $target.find('[data-accordion-menu]');
          if($accordion.length > 0){
            $accordion.each(function(i, select){
              $(select).find('input[type="checkbox"]').on('change', function(e){
                e.preventDefault();
                if($(this).prop('checked')) {
                  $(select).find('input:checked').prop('checked', false);
                  $(this).prop('checked', true);
                }else{
                  $(select).find('input:checked').prop('checked', false);
                  $(select).find('li.is-default input').prop('checked', true);
                }
              });
            });
          }
          if(typeof $(element).data('replaceoption') !== 'undefined'){
            $accordion = $target.find('[data-accordion-menu]');
            var $checkedInput = $accordion.find('input:checked');
            if($checkedInput.length > 0){
              var $span = $checkedInput.eq(0).siblings('span');
              $(element).text($span.text());
              if(typeof $span.data('selectedstyle') !== 'undefined'){
                $(element).prop('style', $span.data('selectedstyle'));
              }
            }
          }else{
            if(typeof $(element).data('default') !== 'undefined'){
              $(element).text($(element).data('default'));
            }
          }
        }else{
          if(typeof $(element).data('default') !== 'undefined'){
            $(element).text($(element).data('default'));
          }
        }
      }
    });
  }
  $.fn.initPopupBlock = function(){
    return this.each(function(index, elem){
      var localStorage = window.localStorage;
      if($(elem).is('.show_once')){
        var item = localStorage.getItem($(elem).attr('id'));
        var timestamp = $(elem).data('timestamp') + '';
        if(item === null || item != timestamp){
          $(elem).addClass('active');
        }
      }
      $(elem).find('.popup_block__field_title').on('click', function(e){
        e.preventDefault();
        localStorage.setItem($(elem).attr('id'), $(elem).data('timestamp'));
        $(elem).fadeOut(400, function(){
          $(elem).remove();
        });
      });
    });
  }
  $.fn.initSharingDialog = function(){
    $('body').on('click', function(e){
      if($(e.target).closest('.social_network_sharing_dropdown').length === 0){
        $(this).find('.social_network_sharing_dropdown__field_link').removeClass('active');
      }
    });
    function replacePlaceholder(source, $container, key, callback){
      if(typeof $container.data('placeholder_' + key) !== 'undefined'){
        var text = $container.data('placeholder_' + key)
        if(typeof callback === 'function'){
          text = callback(text);
        }
        return source.replace("{" + key + "}", text);
      }else{
        return source;
      }
    }
    return this.each(function(index, elem) {
      var $linkTitle = $(elem).find('.social_network_sharing_dropdown__field_link_title');
      var $linkWrapper = $(elem).find('.social_network_sharing_dropdown__field_link');
      var $linkContainer = $(elem).find('.social_network_sharing_dropdown__field_link_container');
      $linkTitle.on('click', function (e) {
        e.preventDefault();
        $linkWrapper.toggleClass('active');
      });
      $(elem).find('.social_network_sharing_dropdown__field_social_networks>li').each(function (i, medium) {
        if($(medium).is('.facebook')){
          var $linkElement = $(medium).find('a');
          var linkStr = $linkElement.data('hrefplaceholder');
          linkStr = replacePlaceholder(linkStr, $linkContainer, 'shareurl');
          $linkElement.prop('href', linkStr);
        }else if($(medium).is('.sms')){
          var $linkElement = $(medium).find('a');
          var linkStr = $linkElement.data('hrefplaceholder');
          linkStr = replacePlaceholder(linkStr, $linkContainer, 'shareurl', function(text){
            return encodeURIComponent(text);
          });
          $linkElement.prop('href', linkStr);
        }else if($(medium).is('.email')){
          var $linkElement = $(medium).find('a');
          var linkStr = $linkElement.data('hrefplaceholder');
          linkStr = replacePlaceholder(linkStr, $linkContainer, 'shareurl', function(text){
            return encodeURIComponent(text);
          });
          $linkElement.prop('href', linkStr);
        }else if($(medium).is('.whatsapp')){
          var $linkElement = $(medium).find('a');
          var linkStr = $linkElement.data('hrefplaceholder');
          linkStr = replacePlaceholder(linkStr, $linkContainer, 'shareurl', function(text){
            return encodeURIComponent(text);
          });
          $linkElement.prop('href', linkStr);
        }else if($(medium).is('.weibo')){
          var $linkElement = $(medium).find('a');
          var linkStr = $linkElement.data('hrefplaceholder');
          linkStr = replacePlaceholder(linkStr, $linkContainer, 'shareurl');
          $linkElement.prop('href', linkStr);
        }else if($(medium).is('.copy')){
          var $linkElement = $(medium).find('a');
          var linkStr = $linkElement.data('hrefplaceholder');
          linkStr = replacePlaceholder(linkStr, $linkContainer, 'shareurl');
          $linkElement.attr('data-clipboard-text', linkStr);
          if(typeof ClipboardJS === 'function') {
            new ClipboardJS('li.copy a');
          }
        }
      });
    });
  }


  $(document).foundation();
  $(document).ready(function(){

    $('#mobile-menu-close-btn').on('click', function(e){
      e.preventDefault();
      $('.mobile-menu').toggleClass('opened');
    });

    $('.mobile-menu-toggler').on('click', function(e){
      e.preventDefault();
      $('.mobile-menu').toggleClass('opened');
    });

    $('[data-slick]').slick({
      customPaging: function(slider, i) {
        return '<button type="button"><span>' + (i+1) + '</span></button>';
      }
    });

    $('.social_network_sharing_dropdown').initSharingDialog();
    $('.custom-block.popup_block').initPopupBlock();

    $('.past_campaign_control__button').initFilterPopup();
    $('.parent_sharing_control__button').initFilterPopup();
    $('.expert_sharing_control__button').initFilterPopup();
    
    $('body').initOverlayPopup();
    $('body').initFooterMenuAccordion();

    // TODO: handle the related parent sharing
    function handleParentSharingSlider(){
      if (Foundation.MediaQuery.is('small only')) {
        if(!$('.parent_sharing__field_related_parent_sharing').is('.slick-initialized')){
          $('.parent_sharing__field_related_parent_sharing').slick({
            dots: true,
            infinite: true,
            arrows: false,
            customPaging: function(slider, i) {
              return '<button type="button"><span>' + (i+1) + '</span></button>';
            }
          });
        }
        if(!$('.parent_sharing__field_related_product_series').is('.slick-initialized')){
          $('.parent_sharing__field_related_product_series').slick({
            dots: false,
            infinite: false,
            arrows: true,
            centerMode: true,
            centerPadding: "35px",
          });
        }
      }else{
        if($('.parent_sharing__field_related_parent_sharing').is('.slick-initialized')){
          $('.parent_sharing__field_related_parent_sharing').slick('unslick');
        }
        if($('.parent_sharing__field_related_product_series').is('.slick-initialized')){
          $('.parent_sharing__field_related_product_series').slick('unslick');
        }
      }
    }
    function handleExpertSharingSlider(){
      if (Foundation.MediaQuery.is('small only')) {
        if(!$('.expert_sharing_category__field_related_product_package').is('.slick-initialized')){
          $('.expert_sharing_category__field_related_product_package').slick({
            dots: false,
            infinite: false,
            arrows: true,
            centerMode: true,
            centerPadding: "35px",
          });
        }
      }else{
        if($('.expert_sharing_category__field_related_product_package').is('.slick-initialized')){
          $('.expert_sharing_category__field_related_product_package').slick('unslick');
        }
      }
    }

    function handleProductAgeRangeSlider(){
      if (Foundation.MediaQuery.is('small only')) {
        if(!$('.product_age_range__field_related_product_package').is('.slick-initialized')){
          $('.product_age_range__field_related_product_package').slick({
            dots: false,
            infinite: false,
            arrows: true,
            centerMode: true,
            centerPadding: "35px",
          });
        }
      }else{
        if($('.product_age_range__field_related_product_package').is('.slick-initialized')){
          $('.product_age_range__field_related_product_package').slick('unslick');
        }
      }
    }

    handleParentSharingSlider();
    $(window).on('changed.zf.mediaquery', handleParentSharingSlider);

    handleExpertSharingSlider();
    $(window).on('changed.zf.mediaquery', handleExpertSharingSlider);

    handleProductAgeRangeSlider();
    $(window).on('changed.zf.mediaquery', handleProductAgeRangeSlider);

    (function(){
      var body = $('body');
      var handler = function(){
        body.toggleClass('scrolled', window.scrollY > 0);
      }

      $(window).on('scroll', handler);
      handler();
    })();
  });
})(jQuery);
