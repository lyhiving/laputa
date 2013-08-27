/* ===================================================
 * bootstrap-transition.js v2.0.2
 * (Infinite Ajax Scroll | jquery.Jcrop | ! X-editable)
 * http://twitter.github.com/bootstrap/javascript.html#transitions
 * ===================================================
 * Copyright 2012 Twitter, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ========================================================== */

!function( $ ) {

  $(function () {

    "use strict"

    /* CSS TRANSITION SUPPORT (https://gist.github.com/373874)
     * ======================================================= */

    $.support.transition = (function () {
      var thisBody = document.body || document.documentElement
        , thisStyle = thisBody.style
        , support = thisStyle.transition !== undefined || thisStyle.WebkitTransition !== undefined || thisStyle.MozTransition !== undefined || thisStyle.MsTransition !== undefined || thisStyle.OTransition !== undefined

      return support && {
        end: (function () {
          var transitionEnd = "TransitionEnd"
          if ( $.browser.webkit ) {
          	transitionEnd = "webkitTransitionEnd"
          } else if ( $.browser.mozilla ) {
          	transitionEnd = "transitionend"
          } else if ( $.browser.opera ) {
          	transitionEnd = "oTransitionEnd"
          }
          return transitionEnd
        }())
      }
    })()

  })

}( window.jQuery );/* ==========================================================
 * bootstrap-alert.js v2.0.2
 * http://twitter.github.com/bootstrap/javascript.html#alerts
 * ==========================================================
 * Copyright 2012 Twitter, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ========================================================== */


!function( $ ){

  "use strict"

 /* ALERT CLASS DEFINITION
  * ====================== */

  var dismiss = '[data-dismiss="alert"]'
    , Alert = function ( el ) {
        $(el).on('click', dismiss, this.close)
      }

  Alert.prototype = {

    constructor: Alert

  , close: function ( e ) {
      var $this = $(this)
        , selector = $this.attr('data-target')
        , $parent

      if (!selector) {
        selector = $this.attr('href')
        selector = selector && selector.replace(/.*(?=#[^\s]*$)/, '') //strip for ie7
      }

      $parent = $(selector)
      $parent.trigger('close')

      e && e.preventDefault()

      $parent.length || ($parent = $this.hasClass('alert') ? $this : $this.parent())

      $parent
        .trigger('close')
        .removeClass('in')

      function removeElement() {
        $parent
          .trigger('closed')
          .remove()
      }

      $.support.transition && $parent.hasClass('fade') ?
        $parent.on($.support.transition.end, removeElement) :
        removeElement()
    }

  }


 /* ALERT PLUGIN DEFINITION
  * ======================= */

  $.fn.alert = function ( option ) {
    return this.each(function () {
      var $this = $(this)
        , data = $this.data('alert')
      if (!data) $this.data('alert', (data = new Alert(this)))
      if (typeof option == 'string') data[option].call($this)
    })
  }

  $.fn.alert.Constructor = Alert


 /* ALERT DATA-API
  * ============== */

  $(function () {
    $('body').on('click.alert.data-api', dismiss, Alert.prototype.close)
  })

}( window.jQuery );/* ============================================================
 * bootstrap-button.js v2.0.2
 * http://twitter.github.com/bootstrap/javascript.html#buttons
 * ============================================================
 * Copyright 2012 Twitter, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ============================================================ */

!function( $ ){

  "use strict"

 /* BUTTON PUBLIC CLASS DEFINITION
  * ============================== */

  var Button = function ( element, options ) {
    this.$element = $(element)
    this.options = $.extend({}, $.fn.button.defaults, options)
  }

  Button.prototype = {

      constructor: Button

    , setState: function ( state ) {
        var d = 'disabled'
          , $el = this.$element
          , data = $el.data()
          , val = $el.is('input') ? 'val' : 'html'

        state = state + 'Text'
        data.resetText || $el.data('resetText', $el[val]())

        $el[val](data[state] || this.options[state])

        // push to event loop to allow forms to submit
        setTimeout(function () {
          state == 'loadingText' ?
            $el.addClass(d).attr(d, d) :
            $el.removeClass(d).removeAttr(d)
        }, 0)
      }

    , toggle: function () {
        var $parent = this.$element.parent('[data-toggle="buttons-radio"]')

        $parent && $parent
          .find('.active')
          .removeClass('active')

        this.$element.toggleClass('active')
      }

  }


 /* BUTTON PLUGIN DEFINITION
  * ======================== */

  $.fn.button = function ( option ) {
    return this.each(function () {
      var $this = $(this)
        , data = $this.data('button')
        , options = typeof option == 'object' && option
      if (!data) $this.data('button', (data = new Button(this, options)))
      if (option == 'toggle') data.toggle()
      else if (option) data.setState(option)
    })
  }

  $.fn.button.defaults = {
    loadingText: 'loading...'
  }

  $.fn.button.Constructor = Button


 /* BUTTON DATA-API
  * =============== */

  $(function () {
    $('body').on('click.button.data-api', '[data-toggle^=button]', function ( e ) {
      var $btn = $(e.target)
      if (!$btn.hasClass('btn')) $btn = $btn.closest('.btn')
      $btn.button('toggle')
    })
  })

}( window.jQuery );/* ==========================================================
 * bootstrap-carousel.js v2.0.2
 * http://twitter.github.com/bootstrap/javascript.html#carousel
 * ==========================================================
 * Copyright 2012 Twitter, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ========================================================== */


!function( $ ){

  "use strict"

 /* CAROUSEL CLASS DEFINITION
  * ========================= */

  var Carousel = function (element, options) {
    this.$element = $(element)
    this.options = $.extend({}, $.fn.carousel.defaults, options)
    this.options.slide && this.slide(this.options.slide)
    this.options.pause == 'hover' && this.$element
      .on('mouseenter', $.proxy(this.pause, this))
      .on('mouseleave', $.proxy(this.cycle, this))
  }

  Carousel.prototype = {

    cycle: function () {
      this.interval = setInterval($.proxy(this.next, this), this.options.interval)
      return this
    }

  , to: function (pos) {
      var $active = this.$element.find('.active')
        , children = $active.parent().children()
        , activePos = children.index($active)
        , that = this

      if (pos > (children.length - 1) || pos < 0) return

      if (this.sliding) {
        return this.$element.one('slid', function () {
          that.to(pos)
        })
      }

      if (activePos == pos) {
        return this.pause().cycle()
      }

      return this.slide(pos > activePos ? 'next' : 'prev', $(children[pos]))
    }

  , pause: function () {
      clearInterval(this.interval)
      this.interval = null
      return this
    }

  , next: function () {
      if (this.sliding) return
      return this.slide('next')
    }

  , prev: function () {
      if (this.sliding) return
      return this.slide('prev')
    }

  , slide: function (type, next) {
      var $active = this.$element.find('.active')
        , $next = next || $active[type]()
        , isCycling = this.interval
        , direction = type == 'next' ? 'left' : 'right'
        , fallback  = type == 'next' ? 'first' : 'last'
        , that = this

      this.sliding = true

      isCycling && this.pause()

      $next = $next.length ? $next : this.$element.find('.item')[fallback]()

      if ($next.hasClass('active')) return

      if (!$.support.transition && this.$element.hasClass('slide')) {
        this.$element.trigger('slide')
        $active.removeClass('active')
        $next.addClass('active')
        this.sliding = false
        this.$element.trigger('slid')
      } else {
        $next.addClass(type)
        $next[0].offsetWidth // force reflow
        $active.addClass(direction)
        $next.addClass(direction)
        this.$element.trigger('slide')
        this.$element.one($.support.transition.end, function () {
          $next.removeClass([type, direction].join(' ')).addClass('active')
          $active.removeClass(['active', direction].join(' '))
          that.sliding = false
          setTimeout(function () {that.$element.trigger('slid')}, 0)
        })
      }

      isCycling && this.cycle()

      return this
    }

  }


 /* CAROUSEL PLUGIN DEFINITION
  * ========================== */

  $.fn.carousel = function ( option ) {
    return this.each(function () {
      var $this = $(this)
        , data = $this.data('carousel')
        , options = typeof option == 'object' && option
      if (!data) $this.data('carousel', (data = new Carousel(this, options)))
      if (typeof option == 'number') data.to(option)
      else if (typeof option == 'string' || (option = options.slide)) data[option]()
      else data.cycle()
    })
  }

  $.fn.carousel.defaults = {
    interval: 5000
  , pause: 'hover'
  }

  $.fn.carousel.Constructor = Carousel


 /* CAROUSEL DATA-API
  * ================= */

  $(function () {
    $('body').on('click.carousel.data-api', '[data-slide]', function ( e ) {
      var $this = $(this), href
        , $target = $($this.attr('data-target') || (href = $this.attr('href')) && href.replace(/.*(?=#[^\s]+$)/, '')) //strip for ie7
        , options = !$target.data('modal') && $.extend({}, $target.data(), $this.data())
      $target.carousel(options)
      e.preventDefault()
    })
  })

}( window.jQuery );/* =============================================================
 * bootstrap-collapse.js v2.0.2
 * http://twitter.github.com/bootstrap/javascript.html#collapse
 * =============================================================
 * Copyright 2012 Twitter, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ============================================================ */

!function( $ ){

  "use strict"

  var Collapse = function ( element, options ) {
  	this.$element = $(element)
    this.options = $.extend({}, $.fn.collapse.defaults, options)

    if (this.options["parent"]) {
      this.$parent = $(this.options["parent"])
    }

    this.options.toggle && this.toggle()
  }

  Collapse.prototype = {

    constructor: Collapse

  , dimension: function () {
      var hasWidth = this.$element.hasClass('width')
      return hasWidth ? 'width' : 'height'
    }

  , show: function () {
      var dimension = this.dimension()
        , scroll = $.camelCase(['scroll', dimension].join('-'))
        , actives = this.$parent && this.$parent.find('.in')
        , hasData

      if (actives && actives.length) {
        hasData = actives.data('collapse')
        actives.collapse('hide')
        hasData || actives.data('collapse', null)
      }

      this.$element[dimension](0)
      this.transition('addClass', 'show', 'shown')
      this.$element[dimension](this.$element[0][scroll])

    }

  , hide: function () {
      var dimension = this.dimension()
      this.reset(this.$element[dimension]())
      this.transition('removeClass', 'hide', 'hidden')
      this.$element[dimension](0)
    }

  , reset: function ( size ) {
      var dimension = this.dimension()

      this.$element
        .removeClass('collapse')
        [dimension](size || 'auto')
        [0].offsetWidth

      this.$element[size ? 'addClass' : 'removeClass']('collapse')

      return this
    }

  , transition: function ( method, startEvent, completeEvent ) {
      var that = this
        , complete = function () {
            if (startEvent == 'show') that.reset()
            that.$element.trigger(completeEvent)
          }

      this.$element
        .trigger(startEvent)
        [method]('in')

      $.support.transition && this.$element.hasClass('collapse') ?
        this.$element.one($.support.transition.end, complete) :
        complete()
  	}

  , toggle: function () {
      this[this.$element.hasClass('in') ? 'hide' : 'show']()
  	}

  }

  /* COLLAPSIBLE PLUGIN DEFINITION
  * ============================== */

  $.fn.collapse = function ( option ) {
    return this.each(function () {
      var $this = $(this)
        , data = $this.data('collapse')
        , options = typeof option == 'object' && option
      if (!data) $this.data('collapse', (data = new Collapse(this, options)))
      if (typeof option == 'string') data[option]()
    })
  }

  $.fn.collapse.defaults = {
    toggle: true
  }

  $.fn.collapse.Constructor = Collapse


 /* COLLAPSIBLE DATA-API
  * ==================== */

  $(function () {
    $('body').on('click.collapse.data-api', '[data-toggle=collapse]', function ( e ) {
      var $this = $(this), href
        , target = $this.attr('data-target')
          || e.preventDefault()
          || (href = $this.attr('href')) && href.replace(/.*(?=#[^\s]+$)/, '') //strip for ie7
        , option = $(target).data('collapse') ? 'toggle' : $this.data()
      $(target).collapse(option)
    })
  })

}( window.jQuery );
/*
 * Project: Twitter Bootstrap Hover Dropdown
 * Author: Cameron Spear
 * Contributors: Mattia Larentis
 *
 * Dependencies?: Twitter Bootstrap's Dropdown plugin
 *
 * A simple plugin to enable twitter bootstrap dropdowns to active on hover and provide a nice user experience.
 *
 * No license, do what you want. I'd love credit or a shoutout, though.
 *
 * http://cameronspear.com/blog/twitter-bootstrap-dropdown-on-hover-plugin/
 */
;(function($, window, undefined) {
    // outside the scope of the jQuery plugin to
    // keep track of all dropdowns
    var $allDropdowns = $();

    // if instantlyCloseOthers is true, then it will instantly
    // shut other nav items when a new one is hovered over
    $.fn.dropdownHover = function(options) {

        // the element we really care about
        // is the dropdown-toggle's parent
        $allDropdowns = $allDropdowns.add(this.parent());

        return this.each(function() {
            var $this = $(this).parent(),
                defaults = {
                    delay: 500,
                    instantlyCloseOthers: true
                },
                data = {
                    delay: $(this).data('delay'),
                    instantlyCloseOthers: $(this).data('close-others')
                },
                options = $.extend(true, {}, defaults, options, data),
                timeout;

            $this.hover(function() {
                if(options.instantlyCloseOthers === true)
                    $allDropdowns.removeClass('open');

                window.clearTimeout(timeout);
                $(this).addClass('open');
            }, function() {
                timeout = window.setTimeout(function() {
                    $this.removeClass('open');
                }, options.delay);
            });
        });
    };

    $(document).ready(function() {
        $('[data-hover="dropdown"]').dropdownHover();
    });
})(jQuery, this);


/* =========================================================
 * bootstrap-modal.js v2.0.2
 * http://twitter.github.com/bootstrap/javascript.html#modals
 * =========================================================
 * Copyright 2012 Twitter, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ========================================================= */


!function( $ ){

  "use strict"

 /* MODAL CLASS DEFINITION
  * ====================== */

  var Modal = function ( content, options ) {
    this.options = options
    this.$element = $(content)
      .delegate('[data-dismiss="modal"]', 'click.dismiss.modal', $.proxy(this.hide, this))
  }

  Modal.prototype = {

      constructor: Modal

    , toggle: function () {
        return this[!this.isShown ? 'show' : 'hide']()
      }

    , show: function () {
        var that = this

        if (this.isShown) return

        $('body').addClass('modal-open')

        this.isShown = true
        this.$element.trigger('show')

        escape.call(this)
        backdrop.call(this, function () {
          var transition = $.support.transition && that.$element.hasClass('fade')

          !that.$element.parent().length && that.$element.appendTo(document.body) //don't move modals dom position

          that.$element
            .show()

          if (transition) {
            that.$element[0].offsetWidth // force reflow
          }

          that.$element.addClass('in')

          transition ?
            that.$element.one($.support.transition.end, function () {that.$element.trigger('shown')}) :
            that.$element.trigger('shown')

        })
      }

    , hide: function ( e ) {
        e && e.preventDefault()

        if (!this.isShown) return

        var that = this
        this.isShown = false

        $('body').removeClass('modal-open')

        escape.call(this)

        this.$element
          .trigger('hide')
          .removeClass('in')

        $.support.transition && this.$element.hasClass('fade') ?
          hideWithTransition.call(this) :
          hideModal.call(this)
      }

  }


 /* MODAL PRIVATE METHODS
  * ===================== */

  function hideWithTransition() {
    var that = this
      , timeout = setTimeout(function () {
          that.$element.off($.support.transition.end)
          hideModal.call(that)
        }, 500)

    this.$element.one($.support.transition.end, function () {
      clearTimeout(timeout)
      hideModal.call(that)
    })
  }

  function hideModal( that ) {
    this.$element
      .hide()
      .trigger('hidden')

    backdrop.call(this)
  }

  function backdrop( callback ) {
    var that = this
      , animate = this.$element.hasClass('fade') ? 'fade' : ''

    if (this.isShown && this.options.backdrop) {
      var doAnimate = $.support.transition && animate

      this.$backdrop = $('<div class="modal-backdrop ' + animate + '" />')
        .appendTo(document.body)

      if (this.options.backdrop != 'static') {
        this.$backdrop.click($.proxy(this.hide, this))
      }

      if (doAnimate) this.$backdrop[0].offsetWidth // force reflow

      this.$backdrop.addClass('in')

      doAnimate ?
        this.$backdrop.one($.support.transition.end, callback) :
        callback()

    } else if (!this.isShown && this.$backdrop) {
      this.$backdrop.removeClass('in')

      $.support.transition && this.$element.hasClass('fade')?
        this.$backdrop.one($.support.transition.end, $.proxy(removeBackdrop, this)) :
        removeBackdrop.call(this)

    } else if (callback) {
      callback()
    }
  }

  function removeBackdrop() {
    this.$backdrop.remove()
    this.$backdrop = null
  }

  function escape() {
    var that = this
    if (this.isShown && this.options.keyboard) {
      $(document).on('keyup.dismiss.modal', function ( e ) {
        e.which == 27 && that.hide()
      })
    } else if (!this.isShown) {
      $(document).off('keyup.dismiss.modal')
    }
  }


 /* MODAL PLUGIN DEFINITION
  * ======================= */

  $.fn.modal = function ( option ) {
    return this.each(function () {
      var $this = $(this)
        , data = $this.data('modal')
        , options = $.extend({}, $.fn.modal.defaults, $this.data(), typeof option == 'object' && option)
      if (!data) $this.data('modal', (data = new Modal(this, options)))
      if (typeof option == 'string') data[option]()
      else if (options.show) data.show()
    })
  }

  $.fn.modal.defaults = {
      backdrop: true
    , keyboard: true
    , show: true
  }

  $.fn.modal.Constructor = Modal


 /* MODAL DATA-API
  * ============== */

  $(function () {
    $('body').on('click.modal.data-api', '[data-toggle="modal"]', function ( e ) {
      var $this = $(this), href
        , $target = $($this.attr('data-target') || (href = $this.attr('href')) && href.replace(/.*(?=#[^\s]+$)/, '')) //strip for ie7
        , option = $target.data('modal') ? 'toggle' : $.extend({}, $target.data(), $this.data())

      e.preventDefault()
      $target.modal(option)
    })
  })

}( window.jQuery );/* ===========================================================
 * bootstrap-tooltip.js v2.0.2
 * http://twitter.github.com/bootstrap/javascript.html#tooltips
 * Inspired by the original jQuery.tipsy by Jason Frame
 * ===========================================================
 * Copyright 2012 Twitter, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ========================================================== */

!function( $ ) {

  "use strict"

 /* TOOLTIP PUBLIC CLASS DEFINITION
  * =============================== */

  var Tooltip = function ( element, options ) {
    this.init('tooltip', element, options)
  }

  Tooltip.prototype = {

    constructor: Tooltip

  , init: function ( type, element, options ) {
      var eventIn
        , eventOut

      this.type = type
      this.$element = $(element)
      this.options = this.getOptions(options)
      this.enabled = true

      if (this.options.trigger != 'manual') {
        eventIn  = this.options.trigger == 'hover' ? 'mouseenter' : 'focus'
        eventOut = this.options.trigger == 'hover' ? 'mouseleave' : 'blur'
        this.$element.on(eventIn, this.options.selector, $.proxy(this.enter, this))
        this.$element.on(eventOut, this.options.selector, $.proxy(this.leave, this))
      }

      this.options.selector ?
        (this._options = $.extend({}, this.options, {trigger: 'manual', selector: ''})) :
        this.fixTitle()
    }

  , getOptions: function ( options ) {
      options = $.extend({}, $.fn[this.type].defaults, options, this.$element.data())

      if (options.delay && typeof options.delay == 'number') {
        options.delay = {
          show: options.delay
        , hide: options.delay
        }
      }

      return options
    }

  , enter: function ( e ) {
      var self = $(e.currentTarget)[this.type](this._options).data(this.type)

      if (!self.options.delay || !self.options.delay.show) {
        self.show()
      } else {
        self.hoverState = 'in'
        setTimeout(function() {
          if (self.hoverState == 'in') {
            self.show()
          }
        }, self.options.delay.show)
      }
    }

  , leave: function ( e ) {
      var self = $(e.currentTarget)[this.type](this._options).data(this.type)

      if (!self.options.delay || !self.options.delay.hide) {
        self.hide()
      } else {
        self.hoverState = 'out'
        setTimeout(function() {
          if (self.hoverState == 'out') {
            self.hide()
          }
        }, self.options.delay.hide)
      }
    }

  , show: function () {
      var $tip
        , inside
        , pos
        , actualWidth
        , actualHeight
        , placement
        , tp

      if (this.hasContent() && this.enabled) {
        $tip = this.tip()
        this.setContent()

        if (this.options.animation) {
          $tip.addClass('fade')
        }

        placement = typeof this.options.placement == 'function' ?
          this.options.placement.call(this, $tip[0], this.$element[0]) :
          this.options.placement

        inside = /in/.test(placement)

        $tip
          .remove()
          .css({top: 0, left: 0, display: 'block'})
          .appendTo(inside ? this.$element : document.body)

        pos = this.getPosition(inside)

        actualWidth = $tip[0].offsetWidth
        actualHeight = $tip[0].offsetHeight

        switch (inside ? placement.split(' ')[1] : placement) {
          case 'bottom':
            tp = {top: pos.top + pos.height, left: pos.left + pos.width / 2 - actualWidth / 2}
            break
          case 'top':
            tp = {top: pos.top - actualHeight, left: pos.left + pos.width / 2 - actualWidth / 2}
            break
          case 'left':
            tp = {top: pos.top + pos.height / 2 - actualHeight / 2, left: pos.left - actualWidth}
            break
          case 'right':
            tp = {top: pos.top + pos.height / 2 - actualHeight / 2, left: pos.left + pos.width}
            break
        }

        $tip
          .css(tp)
          .addClass(placement)
          .addClass('in')
      }
    }

  , setContent: function () {
      var $tip = this.tip()
      $tip.find('.tooltip-inner').html(this.getTitle())
      $tip.removeClass('fade in top bottom left right')
    }

  , hide: function () {
      var that = this
        , $tip = this.tip()

      $tip.removeClass('in')

      function removeWithAnimation() {
        var timeout = setTimeout(function () {
          $tip.off($.support.transition.end).remove()
        }, 500)

        $tip.one($.support.transition.end, function () {
          clearTimeout(timeout)
          $tip.remove()
        })
      }

      $.support.transition && this.$tip.hasClass('fade') ?
        removeWithAnimation() :
        $tip.remove()
    }

  , fixTitle: function () {
      var $e = this.$element
      if ($e.attr('title') || typeof($e.attr('data-original-title')) != 'string') {
        $e.attr('data-original-title', $e.attr('title') || '').removeAttr('title')
      }
    }

  , hasContent: function () {
      return this.getTitle()
    }

  , getPosition: function (inside) {
      return $.extend({}, (inside ? {top: 0, left: 0} : this.$element.offset()), {
        width: this.$element[0].offsetWidth
      , height: this.$element[0].offsetHeight
      })
    }

  , getTitle: function () {
      var title
        , $e = this.$element
        , o = this.options

      title = $e.attr('data-original-title')
        || (typeof o.title == 'function' ? o.title.call($e[0]) :  o.title)

      title = (title || '').toString().replace(/(^\s*|\s*$)/, "")

      return title
    }

  , tip: function () {
      return this.$tip = this.$tip || $(this.options.template)
    }

  , validate: function () {
      if (!this.$element[0].parentNode) {
        this.hide()
        this.$element = null
        this.options = null
      }
    }

  , enable: function () {
      this.enabled = true
    }

  , disable: function () {
      this.enabled = false
    }

  , toggleEnabled: function () {
      this.enabled = !this.enabled
    }

  , toggle: function () {
      this[this.tip().hasClass('in') ? 'hide' : 'show']()
    }

  }


 /* TOOLTIP PLUGIN DEFINITION
  * ========================= */

  $.fn.tooltip = function ( option ) {
    return this.each(function () {
      var $this = $(this)
        , data = $this.data('tooltip')
        , options = typeof option == 'object' && option
      if (!data) $this.data('tooltip', (data = new Tooltip(this, options)))
      if (typeof option == 'string') data[option]()
    })
  }

  $.fn.tooltip.Constructor = Tooltip

  $.fn.tooltip.defaults = {
    animation: true
  , delay: 0
  , selector: false
  , placement: 'top'
  , trigger: 'hover'
  , title: ''
  , template: '<div class="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>'
  }

}( window.jQuery );/* ===========================================================
 * bootstrap-popover.js v2.0.2
 * http://twitter.github.com/bootstrap/javascript.html#popovers
 * ===========================================================
 * Copyright 2012 Twitter, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * =========================================================== */


!function( $ ) {

 "use strict"

  var Popover = function ( element, options ) {
    this.init('popover', element, options)
  }

  /* NOTE: POPOVER EXTENDS BOOTSTRAP-TOOLTIP.js
     ========================================== */

  Popover.prototype = $.extend({}, $.fn.tooltip.Constructor.prototype, {

    constructor: Popover

  , setContent: function () {
      var $tip = this.tip()
        , title = this.getTitle()
        , content = this.getContent()

      $tip.find('.popover-title')[ $.type(title) == 'object' ? 'append' : 'html' ](title)
      $tip.find('.popover-content > *')[ $.type(content) == 'object' ? 'append' : 'html' ](content)

      $tip.removeClass('fade top bottom left right in')
    }

  , hasContent: function () {
      return this.getTitle() || this.getContent()
    }

  , getContent: function () {
      var content
        , $e = this.$element
        , o = this.options

      content = $e.attr('data-content')
        || (typeof o.content == 'function' ? o.content.call($e[0]) :  o.content)

      content = content.toString().replace(/(^\s*|\s*$)/, "")

      return content
    }

  , tip: function() {
      if (!this.$tip) {
        this.$tip = $(this.options.template)
      }
      return this.$tip
    }

  })


 /* POPOVER PLUGIN DEFINITION
  * ======================= */

  $.fn.popover = function ( option ) {
    return this.each(function () {
      var $this = $(this)
        , data = $this.data('popover')
        , options = typeof option == 'object' && option
      if (!data) $this.data('popover', (data = new Popover(this, options)))
      if (typeof option == 'string') data[option]()
    })
  }

  $.fn.popover.Constructor = Popover

  $.fn.popover.defaults = $.extend({} , $.fn.tooltip.defaults, {
    placement: 'right'
  , content: ''
  , template: '<div class="popover"><div class="arrow"></div><div class="popover-inner"><h3 class="popover-title"></h3><div class="popover-content"><p></p></div></div></div>'
  })

}( window.jQuery );/* =============================================================
 * bootstrap-scrollspy.js v2.0.2
 * http://twitter.github.com/bootstrap/javascript.html#scrollspy
 * =============================================================
 * Copyright 2012 Twitter, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ============================================================== */

!function ( $ ) {

  "use strict"

  /* SCROLLSPY CLASS DEFINITION
   * ========================== */

  function ScrollSpy( element, options) {
    var process = $.proxy(this.process, this)
      , $element = $(element).is('body') ? $(window) : $(element)
      , href
    this.options = $.extend({}, $.fn.scrollspy.defaults, options)
    this.$scrollElement = $element.on('scroll.scroll.data-api', process)
    this.selector = (this.options.target
      || ((href = $(element).attr('href')) && href.replace(/.*(?=#[^\s]+$)/, '')) //strip for ie7
      || '') + ' .nav li > a'
    this.$body = $('body').on('click.scroll.data-api', this.selector, process)
    this.refresh()
    this.process()
  }

  ScrollSpy.prototype = {

      constructor: ScrollSpy

    , refresh: function () {
        this.targets = this.$body
          .find(this.selector)
          .map(function () {
            var href = $(this).attr('href')
            return /^#\w/.test(href) && $(href).length ? href : null
          })

        this.offsets = $.map(this.targets, function (id) {
          return $(id).position().top
        })
      }

    , process: function () {
        var scrollTop = this.$scrollElement.scrollTop() + this.options.offset
          , offsets = this.offsets
          , targets = this.targets
          , activeTarget = this.activeTarget
          , i

        for (i = offsets.length; i--;) {
          activeTarget != targets[i]
            && scrollTop >= offsets[i]
            && (!offsets[i + 1] || scrollTop <= offsets[i + 1])
            && this.activate( targets[i] )
        }
      }

    , activate: function (target) {
        var active

        this.activeTarget = target

        this.$body
          .find(this.selector).parent('.active')
          .removeClass('active')

        active = this.$body
          .find(this.selector + '[href="' + target + '"]')
          .parent('li')
          .addClass('active')

        if ( active.parent('.dropdown-menu') )  {
          active.closest('li.dropdown').addClass('active')
        }
      }

  }


 /* SCROLLSPY PLUGIN DEFINITION
  * =========================== */

  $.fn.scrollspy = function ( option ) {
    return this.each(function () {
      var $this = $(this)
        , data = $this.data('scrollspy')
        , options = typeof option == 'object' && option
      if (!data) $this.data('scrollspy', (data = new ScrollSpy(this, options)))
      if (typeof option == 'string') data[option]()
    })
  }

  $.fn.scrollspy.Constructor = ScrollSpy

  $.fn.scrollspy.defaults = {
    offset: 10
  }


 /* SCROLLSPY DATA-API
  * ================== */

  $(function () {
    $('[data-spy="scroll"]').each(function () {
      var $spy = $(this)
      $spy.scrollspy($spy.data())
    })
  })

}( window.jQuery );/* ========================================================
 * bootstrap-tab.js v2.0.2
 * http://twitter.github.com/bootstrap/javascript.html#tabs
 * ========================================================
 * Copyright 2012 Twitter, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ======================================================== */


!function( $ ){

  "use strict"

 /* TAB CLASS DEFINITION
  * ==================== */

  var Tab = function ( element ) {
    this.element = $(element)
  }

  Tab.prototype = {

    constructor: Tab

  , show: function () {
      var $this = this.element
        , $ul = $this.closest('ul:not(.dropdown-menu)')
        , selector = $this.attr('data-target')
        , previous
        , $target

      if (!selector) {
        selector = $this.attr('href')
        selector = selector && selector.replace(/.*(?=#[^\s]*$)/, '') //strip for ie7
      }

      if ( $this.parent('li').hasClass('active') ) return

      previous = $ul.find('.active a').last()[0]

      $this.trigger({
        type: 'show'
      , relatedTarget: previous
      })

      $target = $(selector)

      this.activate($this.parent('li'), $ul)
      this.activate($target, $target.parent(), function () {
        $this.trigger({
          type: 'shown'
        , relatedTarget: previous
        })
      })
    }

  , activate: function ( element, container, callback) {
      var $active = container.find('> .active')
        , transition = callback
            && $.support.transition
            && $active.hasClass('fade')

      function next() {
        $active
          .removeClass('active')
          .find('> .dropdown-menu > .active')
          .removeClass('active')

        element.addClass('active')

        if (transition) {
          element[0].offsetWidth // reflow for transition
          element.addClass('in')
        } else {
          element.removeClass('fade')
        }

        if ( element.parent('.dropdown-menu') ) {
          element.closest('li.dropdown').addClass('active')
        }

        callback && callback()
      }

      transition ?
        $active.one($.support.transition.end, next) :
        next()

      $active.removeClass('in')
    }
  }


 /* TAB PLUGIN DEFINITION
  * ===================== */

  $.fn.tab = function ( option ) {
    return this.each(function () {
      var $this = $(this)
        , data = $this.data('tab')
      if (!data) $this.data('tab', (data = new Tab(this)))
      if (typeof option == 'string') data[option]()
    })
  }

  $.fn.tab.Constructor = Tab


 /* TAB DATA-API
  * ============ */

  $(function () {
    $('body').on('click.tab.data-api', '[data-toggle="tab"], [data-toggle="pill"]', function (e) {
      e.preventDefault()
      $(this).tab('show')
    })
  })

}( window.jQuery );/* =============================================================
 * bootstrap-typeahead.js v2.0.2
 * http://twitter.github.com/bootstrap/javascript.html#typeahead
 * =============================================================
 * Copyright 2012 Twitter, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ============================================================ */

!function( $ ){

  "use strict"

  var Typeahead = function ( element, options ) {
    this.$element = $(element)
    this.$element.attr('autocomplete', 'off')
    this.options = $.extend({}, $.fn.typeahead.defaults, options)
    this.matcher = this.options.matcher || this.matcher
    this.sorter = this.options.sorter || this.sorter
    this.highlighter = this.options.highlighter || this.highlighter
    this.$menu = $(this.options.menu).appendTo('body')
    this.source = this.options.source
    this.shown = false
    this.listen()
  }

  Typeahead.prototype = {

    constructor: Typeahead

  , select: function () {
      var val = this.$menu.find('.active').attr('data-value')
      this.$element.val(val)
      this.$element.change();
      this.$element.trigger('selected')
      return this.hide()
    }

  , show: function () {
      var pos = $.extend({}, this.$element.offset(), {
        height: this.$element[0].offsetHeight
      })

      this.$menu.css({
        top: pos.top + pos.height
      , left: pos.left
      })

      this.$menu.show()
      this.shown = true
      return this
    }

  , hide: function () {
      this.$menu.hide()
      this.shown = false
      return this
    }

  , lookup: function (event) {
      var that = this
        , items
        , q

      this.query = this.$element.val()

      if (!this.query) {
        return this.shown ? this.hide() : this
      }

      items = $.grep(this.source, function (item) {
        if (that.matcher(item)) return item
      })

      items = this.sorter(items)

      if (!items.length) {
        return this.shown ? this.hide() : this
      }

      return this.render(items.slice(0, this.options.items)).show()
    }

  , matcher: function (item) {
      return ~item.toLowerCase().indexOf(this.query.toLowerCase())
    }

  , sorter: function (items) {
      var beginswith = []
        , caseSensitive = []
        , caseInsensitive = []
        , item

      while (item = items.shift()) {
        if (!item.toLowerCase().indexOf(this.query.toLowerCase())) beginswith.push(item)
        else if (~item.indexOf(this.query)) caseSensitive.push(item)
        else caseInsensitive.push(item)
      }

      return beginswith.concat(caseSensitive, caseInsensitive)
    }

  , highlighter: function (item) {
      return item.replace(new RegExp('(' + this.query + ')', 'ig'), function ($1, match) {
        return '<strong>' + match + '</strong>'
      })
    }

  , render: function (items) {
      var that = this
      ,value
      ,label

      items = $(items).map(function (i, item) {

	if (typeof(item) == 'object') {
		value = item.value
		label = item.label
	} else {
		value = label = item
	}
        i = $(that.options.item).attr('data-value', value)
        i.find('a').html(that.highlighter(label))
        return i[0]
      })

      items.first().addClass('active')
      this.$menu.html(items)
      return this
    }

  , next: function (event) {
      var active = this.$menu.find('.active').removeClass('active')
        , next = active.next()

      if (!next.length) {
        next = $(this.$menu.find('li')[0])
      }

      next.addClass('active')
    }

  , prev: function (event) {
      var active = this.$menu.find('.active').removeClass('active')
        , prev = active.prev()

      if (!prev.length) {
        prev = this.$menu.find('li').last()
      }

      prev.addClass('active')
    }

  , listen: function () {
      this.$element
        .on('blur',     $.proxy(this.blur, this))
        .on('keypress', $.proxy(this.keypress, this))
        .on('keyup',    $.proxy(this.keyup, this))

      if ($.browser.webkit || $.browser.msie) {
        this.$element.on('keydown', $.proxy(this.keypress, this))
      }

      this.$menu
        .on('click', $.proxy(this.click, this))
        .on('mouseenter', 'li', $.proxy(this.mouseenter, this))
    }

  , keyup: function (e) {
      switch(e.keyCode) {
        case 40: // down arrow
        case 38: // up arrow
          break

        case 9: // tab
        case 13: // enter
          if (!this.shown) return
          this.select()
          break

        case 27: // escape
          if (!this.shown) return
          this.hide()
          break

        default:
          this.lookup()
      }

      e.stopPropagation()
      e.preventDefault()
  }

  , keypress: function (e) {
      if (!this.shown) return

      switch(e.keyCode) {
        case 9: // tab
        case 13: // enter
        case 27: // escape
          e.preventDefault()
          break

        case 38: // up arrow
          e.preventDefault()
          this.prev()
          break

        case 40: // down arrow
          e.preventDefault()
          this.next()
          break
      }

      e.stopPropagation()
    }

  , blur: function (e) {
      var that = this
      setTimeout(function () {that.hide()}, 150)
    }

  , click: function (e) {
      e.stopPropagation()
      e.preventDefault()
      this.select()
    }

  , mouseenter: function (e) {
      this.$menu.find('.active').removeClass('active')
      $(e.currentTarget).addClass('active')
    }

  }


  /* TYPEAHEAD PLUGIN DEFINITION
   * =========================== */

  $.fn.typeahead = function ( option ) {
    return this.each(function () {
      var $this = $(this)
        , data = $this.data('typeahead')
        , options = typeof option == 'object' && option
      if (!data) $this.data('typeahead', (data = new Typeahead(this, options)))
      if (typeof option == 'string') data[option]()
    })
  }

  $.fn.typeahead.defaults = {
    source: []
  , items: 8
  , menu: '<ul class="typeahead dropdown-menu"></ul>'
  , item: '<li><a href="#"></a></li>'
  }

  $.fn.typeahead.Constructor = Typeahead


 /* TYPEAHEAD DATA-API
  * ================== */

  $(function () {
    $('body').on('focus.typeahead.data-api', '[data-provide="typeahead"]', function (e) {
      var $this = $(this)
      if ($this.data('typeahead')) return
      e.preventDefault()
      $this.typeahead($this.data())
    })
  })

}( window.jQuery );





/*!
 * Infinite Ajax Scroll, a jQuery plugin
 * Version 1.0.2
 * https://github.com/webcreate/infinite-ajax-scroll
 *
 * Copyright (c) 2011-2013 Jeroen Fiege
 * Licensed under MIT:
 * https://raw.github.com/webcreate/infinite-ajax-scroll/master/MIT-LICENSE.txt
 */

(function ($) {

    'use strict';

    Date.now = Date.now || function () { return +new Date(); };

    $.ias = function (options)
    {
        // setup
        var opts             = $.extend({}, $.ias.defaults, options);
        var util             = new $.ias.util();                                // utilities module
        var paging           = new $.ias.paging(opts.scrollContainer);          // paging module
        var hist             = (opts.history ? new $.ias.history() : false);    // history module
        var _self            = this;

        /**
         * Initialize
         *
         * - tracks scrolling through pages
         * - remembers current page with the history module
         * - setup scroll event and hides pagination element
         * - loads and scrolls to previous page when we have something in our history
         *
         * @return self
         */
        function init()
        {
            var pageNum;

            // track page number changes
            paging.onChangePage(function (pageNum, scrollOffset, pageUrl) {
                if (hist) {
                    hist.setPage(pageNum, pageUrl);
                }

                // call onPageChange event
                opts.onPageChange.call(this, pageNum, pageUrl, scrollOffset);
            });

            if (opts.triggerPageThreshold > 0) {
                // setup scroll and hide pagination
                reset();
            } else if ($(opts.next).attr('href')) {
                var curScrOffset = util.getCurrentScrollOffset(opts.scrollContainer);
                show_trigger(function () {
                    paginate(curScrOffset);
                });
            }

            // load and scroll to previous page
            if (hist && hist.havePage()) {
                stop_scroll();

                pageNum = hist.getPage();

                util.forceScrollTop(function () {
                    var curThreshold;

                    if (pageNum > 1) {
                        paginateToPage(pageNum);

                        curThreshold = get_scroll_threshold(true);
                        $('html, body').scrollTop(curThreshold);
                    }
                    else {
                        reset();
                    }
                });
            }

            return _self;
        }

        // initialize
        init();

        /**
         * Reset scrolling and hide pagination links
         *
         * @return void
         */
        function reset()
        {
            hide_pagination();

            opts.scrollContainer.scroll(scroll_handler);
        }

        /**
         * Scroll event handler
         *
         * @return void
         */
        function scroll_handler()
        {
            var curScrOffset,
                scrThreshold;

            curScrOffset = util.getCurrentScrollOffset(opts.scrollContainer);
            scrThreshold = get_scroll_threshold();

            if (curScrOffset >= scrThreshold) {
                if (get_current_page() >= opts.triggerPageThreshold) {
                    stop_scroll();
                    show_trigger(function () {
                        paginate(curScrOffset);
                    });
                }
                else {
                    paginate(curScrOffset);
                }
            }
        }

        /**
         * Cancel scrolling
         *
         * @return void
         */
        function stop_scroll()
        {
            opts.scrollContainer.unbind('scroll', scroll_handler);
        }

        /**
         * Hide pagination
         *
         * @return void
         */
        function hide_pagination()
        {
            $(opts.pagination).hide();
        }

        /**
         * Get scroll threshold based on the last item element
         *
         * @param boolean pure indicates if the thresholdMargin should be applied
         * @return integer threshold
         */
        function get_scroll_threshold(pure)
        {
            var el,
                threshold;

            el = $(opts.container).find(opts.item).last();

            if (el.size() === 0) {
                return 0;
            }

            threshold = el.offset().top + el.height();

            if (!pure) {
                threshold += opts.thresholdMargin;
            }

            return threshold;
        }

        /**
         * Load the items from the next page.
         *
         * @param int      curScrOffset      current scroll offset
         * @param function onCompleteHandler callback function
         * @return void
         */
        function paginate(curScrOffset, onCompleteHandler)
        {
            var urlNextPage;

            urlNextPage = $(opts.next).attr('href');
            if (!urlNextPage) {
                if (opts.noneleft) {
                    $(opts.container).find(opts.item).last().after(opts.noneleft);
                }
                return stop_scroll();
            }

            if (opts.beforePageChange && $.isFunction(opts.beforePageChange)) {
                if (opts.beforePageChange(curScrOffset, urlNextPage) === false) {
                    return;
                }
            }

            paging.pushPages(curScrOffset, urlNextPage);

            stop_scroll();
            show_loader();

            loadItems(urlNextPage, function (data, items) {
                // call the onLoadItems callback
                var result = opts.onLoadItems.call(this, items),
                    curLastItem;

                if (result !== false) {
                    $(items).hide();  // at first, hide it so we can fade it in later

                    // insert them after the last item with a nice fadeIn effect
                    curLastItem = $(opts.container).find(opts.item).last();
                    curLastItem.after(items);
                    $(items).fadeIn();
                }

                urlNextPage = $(opts.next, data).attr('href');

                // update pagination
                $(opts.pagination).replaceWith($(opts.pagination, data));

                remove_loader();
                hide_pagination();

                if (urlNextPage) {
                    reset();
                }
                else {
                    stop_scroll();
                }

                // call the onRenderComplete callback
                opts.onRenderComplete.call(this, items);

                if (onCompleteHandler) {
                    onCompleteHandler.call(this);
                }
            });
        }

        /**
         * Loads items from certain url, triggers
         * onComplete handler when finished
         *
         * @param string   the url to load
         * @param function the callback function
         * @param int      minimal time the loading should take, defaults to $.ias.default.loaderDelay
         * @return void
         */
        function loadItems(url, onCompleteHandler, delay)
        {
            var items = [],
                container,
                startTime = Date.now(),
                diffTime,
                self;

            delay = delay || opts.loaderDelay;

            $.get(url, null, function (data) {
                // walk through the items on the next page
                // and add them to the items array
                container = $(opts.container, data).eq(0);
                if (0 === container.length) {
                    // incase the element is a root element (body > element),
                    // try to filter it
                    container = $(data).filter(opts.container).eq(0);
                }

                if (container) {
                    container.find(opts.item).each(function () {
                        items.push(this);
                    });
                }

                if (onCompleteHandler) {
                    self = this;
                    diffTime = Date.now() - startTime;
                    if (diffTime < delay) {
                        setTimeout(function () {
                            onCompleteHandler.call(self, data, items);
                        }, delay - diffTime);
                    } else {
                        onCompleteHandler.call(self, data, items);
                    }
                }
            }, 'html');
        }

        /**
         * Paginate to a certain page number.
         *
         * - keeps paginating till the pageNum is reached
         *
         * @return void
         */
        function paginateToPage(pageNum)
        {
            var curThreshold = get_scroll_threshold(true);

            if (curThreshold > 0) {
                paginate(curThreshold, function () {
                    stop_scroll();

                    if ((paging.getCurPageNum(curThreshold) + 1) < pageNum) {
                        paginateToPage(pageNum);

                        $('html,body').animate({'scrollTop': curThreshold}, 400, 'swing');
                    }
                    else {
                        $('html,body').animate({'scrollTop': curThreshold}, 1000, 'swing');

                        reset();
                    }
                });
            }
        }

        function get_current_page()
        {
            var curScrOffset = util.getCurrentScrollOffset(opts.scrollContainer);

            return paging.getCurPageNum(curScrOffset);
        }

        /**
         * Return the active loader or creates a new loader
         *
         * @return object loader jquery object
         */
        function get_loader()
        {
            var loader = $('.ias_loader');

            if (loader.size() === 0) {
                loader = $('<div class="ias_loader">' + opts.loader + '</div>');
                loader.hide();
            }
            return loader;
        }

        /**
         * Inserts the loader and does a fadeIn.
         *
         * @return void
         */
        function show_loader()
        {
            var loader = get_loader(),
                el;

            if (opts.customLoaderProc !== false) {
                opts.customLoaderProc(loader);
            } else {
                el = $(opts.container).find(opts.item).last();
                el.after(loader);
                loader.fadeIn();
            }
        }

        /**
         * Removes the loader.
         *
         * return void
         */
        function remove_loader()
        {
            var loader = get_loader();
            loader.remove();
        }

        /**
         * Return the active trigger or creates a new trigger
         *
         * @return object trigger jquery object
         */
        function get_trigger(callback)
        {
            var trigger = $('.ias_trigger');

            if (trigger.size() === 0) {
                trigger = $('<div class="ias_trigger">' + opts.trigger + '</div>');
                trigger.hide();
            }

            $('a', trigger)
                //.unbind('click') Gavin
                //.bind('click', function () { remove_trigger(); callback.call(); return false; })
            ;

            return trigger;
        }

        /**
         * @param function callback of the trigger (get's called onClick)
         */
        function show_trigger(callback)
        {
            var trigger = get_trigger(callback),
                el;

            if (opts.customTriggerProc !== false) {
                opts.customTriggerProc(trigger);
            } else {
                el = $(opts.container).find(opts.item).last();
                el.after(trigger);
                trigger.fadeIn();
            }
        }

        /**
         * Removes the trigger.
         *
         * return void
         */
        function remove_trigger()
        {
            var trigger = get_trigger();

            trigger.remove();
        }
    };

    // plugin defaults
    $.ias.defaults = {
        container: '#container',
        scrollContainer: $(window),
        item: '.item',
        pagination: '#pagination',
        next: '.next',
        noneleft: false,
        loader: '<img src="images/loader.gif"/>',
        loaderDelay: 600,
        triggerPageThreshold: 3,
        trigger: 'Load more items',
        thresholdMargin: 0,
        history : true,
        onPageChange: function () {},
        beforePageChange: function () {},
        onLoadItems: function () {},
        onRenderComplete: function () {},
        customLoaderProc: false,
        customTriggerProc: false
    };

    // utility module
    $.ias.util = function ()
    {
        // setup
        var wndIsLoaded = false;
        var forceScrollTopIsCompleted = false;
        var self = this;

        /**
         * Initialize
         *
         * @return void
         */
        function init()
        {
            $(window).load(function () {
                wndIsLoaded = true;
            });
        }

        // initialize
        init();

        /**
         * Force browsers to scroll to top.
         *
         * - When you hit back in you browser, it automatically scrolls
         *   back to the last position. There is no way to stop this
         *   in a nice way, so this function does it the hard way.
         *
         * @param function onComplete callback function
         * @return void
         */
        this.forceScrollTop = function (onCompleteHandler)
        {
            $('html,body').scrollTop(0);

            if (!forceScrollTopIsCompleted) {
                if (!wndIsLoaded) {
                    setTimeout(function () {self.forceScrollTop(onCompleteHandler); }, 1);
                } else {
                    onCompleteHandler.call();
                    forceScrollTopIsCompleted = true;
                }
            }
        };

        this.getCurrentScrollOffset = function (container)
        {
            var scrTop,
                wndHeight;

            // the way we calculate if we have to load the next page depends on which container we have
            if (container.get(0) === window) {
                scrTop = container.scrollTop();
            } else {
                scrTop = container.offset().top;
            }

            wndHeight = container.height();

            return scrTop + wndHeight;
        };
    };

    // paging module
    $.ias.paging = function ()
    {
        // setup
        var pagebreaks        = [[0, document.location.toString()]];
        var changePageHandler = function () {};
        var lastPageNum       = 1;
        var util              = new $.ias.util();

        /**
         * Initialize
         *
         * @return void
         */
        function init()
        {
            $(window).scroll(scroll_handler);
        }

        // initialize
        init();

        /**
         * Scroll handler
         *
         * - Triggers changePage event
         *
         * @return void
         */
        function scroll_handler()
        {
            var curScrOffset,
                curPageNum,
                curPagebreak,
                scrOffset,
                urlPage;

            curScrOffset = util.getCurrentScrollOffset($(window));

            curPageNum = getCurPageNum(curScrOffset);
            curPagebreak = getCurPagebreak(curScrOffset);

            if (lastPageNum !== curPageNum) {
                scrOffset = curPagebreak[0];
                urlPage = curPagebreak[1];
                changePageHandler.call({}, curPageNum, scrOffset, urlPage); // @todo fix for window height
            }

            lastPageNum = curPageNum;
        }

        /**
         * Returns current page number based on scroll offset
         *
         * @param int scroll offset
         * @return int current page number
         */
        function getCurPageNum(scrollOffset)
        {
            for (var i = (pagebreaks.length - 1); i > 0; i--) {
                if (scrollOffset > pagebreaks[i][0]) {
                    return i + 1;
                }
            }
            return 1;
        }

        /**
         * Public function for getCurPageNum
         *
         * @param int scrollOffset defaulst to the current
         * @return int current page number
         */
        this.getCurPageNum = function (scrollOffset)
        {
            scrollOffset = scrollOffset || util.getCurrentScrollOffset($(window));

            return getCurPageNum(scrollOffset);
        };

        /**
         * Returns current pagebreak information based on scroll offset
         *
         * @param int scroll offset
         * @return array pagebreak information
         */
        function getCurPagebreak(scrollOffset)
        {
            for (var i = (pagebreaks.length - 1); i >= 0; i--) {
                if (scrollOffset > pagebreaks[i][0]) {
                    return pagebreaks[i];
                }
            }
            return null;
        }

        /**
         * Sets onchangePage event handler
         *
         * @param function event handler
         * @return void
         */
        this.onChangePage = function (fn)
        {
            changePageHandler = fn;
        };

        /**
         * pushes the pages tracker
         *
         * @param int scroll offset for the new page
         * @return void
         */
        this.pushPages = function (scrollOffset, urlNextPage)
        {
            pagebreaks.push([scrollOffset, urlNextPage]);
        };
    };

    // history module
    $.ias.history = function ()
    {
        // setup
        var isPushed = false;
        var isHtml5 = false;

        /**
         * Initialize
         *
         * @return void
         */
        function init()
        {
            isHtml5 = !!(window.history && history.pushState && history.replaceState);
            isHtml5 = false; // html5 functions disabled due to problems in chrome
        }

        // initialize
        init();

        /**
         * Sets page to history
         *
         * @return void;
         */
        this.setPage = function (pageNum, pageUrl)
        {
            this.updateState({page : pageNum}, '', pageUrl);
        };

        /**
         * Checks if we have a page set in the history
         *
         * @return bool returns true when we have a previous page, false otherwise
         */
        this.havePage = function ()
        {
            return (this.getState() !== false);
        };

        /**
         * Gets the previous page from history
         *
         * @return int page number of previous page
         */
        this.getPage = function ()
        {
            var stateObj;

            if (this.havePage()) {
                stateObj = this.getState();
                return stateObj.page;
            }
            return 1;
        };

        /**
         * Returns current state
         *
         * @return object stateObj
         */
        this.getState = function ()
        {
            var haveState,
                stateObj,
                pageNum;

            if (isHtml5) {
                stateObj = history.state;
                if (stateObj && stateObj.ias) {
                    return stateObj.ias;
                }
            }
            else {
                haveState = (window.location.hash.substring(0, 7) === '#/page/');
                if (haveState) {
                    pageNum = parseInt(window.location.hash.replace('#/page/', ''), 10);
                    return { page : pageNum };
                }
            }

            return false;
        };

        /**
         * Pushes state when not pushed already, otherwise
         * replaces the state.
         *
         * @param obj stateObj
         * @param string title
         * @param string url
         * @return void
         */
        this.updateState = function (stateObj, title, url)
        {
            if (isPushed) {
                this.replaceState(stateObj, title, url);
            }
            else {
                this.pushState(stateObj, title, url);
            }
        };

        /**
         * Pushes state to history.
         *
         * @param obj stateObj
         * @param string title
         * @param string url
         * @return void
         */
        this.pushState = function (stateObj, title, url)
        {
            var hash;

            if (isHtml5) {
                history.pushState({ ias : stateObj }, title, url);
            }
            else {
                hash = (stateObj.page > 0 ? '#/page/' + stateObj.page : '');
                window.location.hash = hash;
            }

            isPushed = true;
        };

        /**
         * Replaces current history state.
         *
         * @param obj stateObj
         * @param string title
         * @param string url
         * @return void
         */
        this.replaceState = function (stateObj, title, url)
        {
            if (isHtml5) {
                history.replaceState({ ias : stateObj }, title, url);
            }
            else {
                this.pushState(stateObj, title, url);
            }
        };
    };
})(jQuery);



/*! X-editable - v1.4.5 
* In-place editing with Twitter Bootstrap, jQuery UI or pure jQuery
* http://github.com/vitalets/x-editable
* Copyright (c) 2013 Vitaliy Potapov; Licensed MIT */
(function(e){"use strict";var t=function(t,n){this.options=e.extend({},e.fn.editableform.defaults,n),this.$div=e(t),this.options.scope||(this.options.scope=this)};t.prototype={constructor:t,initInput:function(){this.input=this.options.input,this.value=this.input.str2value(this.options.value)},initTemplate:function(){this.$form=e(e.fn.editableform.template)},initButtons:function(){var t=this.$form.find(".editable-buttons");t.append(e.fn.editableform.buttons),this.options.showbuttons==="bottom"&&t.addClass("editable-buttons-bottom")},render:function(){this.$loading=e(e.fn.editableform.loading),this.$div.empty().append(this.$loading),this.initTemplate(),this.options.showbuttons?this.initButtons():this.$form.find(".editable-buttons").remove(),this.showLoading(),this.isSaving=!1,this.$div.triggerHandler("rendering"),this.initInput(),this.input.prerender(),this.$form.find("div.editable-input").append(this.input.$tpl),this.$div.append(this.$form),e.when(this.input.render()).then(e.proxy(function(){this.options.showbuttons||this.input.autosubmit(),this.$form.find(".editable-cancel").click(e.proxy(this.cancel,this)),this.input.error?(this.error(this.input.error),this.$form.find(".editable-submit").attr("disabled",!0),this.input.$input.attr("disabled",!0),this.$form.submit(function(e){e.preventDefault()})):(this.error(!1),this.input.$input.removeAttr("disabled"),this.$form.find(".editable-submit").removeAttr("disabled"),this.input.value2input(this.value),this.$form.submit(e.proxy(this.submit,this))),this.$div.triggerHandler("rendered"),this.showForm(),this.input.postrender&&this.input.postrender()},this))},cancel:function(){this.$div.triggerHandler("cancel")},showLoading:function(){var e,t;this.$form?(e=this.$form.outerWidth(),t=this.$form.outerHeight(),e&&this.$loading.width(e),t&&this.$loading.height(t),this.$form.hide()):(e=this.$loading.parent().width(),e&&this.$loading.width(e)),this.$loading.show()},showForm:function(e){this.$loading.hide(),this.$form.show(),e!==!1&&this.input.activate(),this.$div.triggerHandler("show")},error:function(t){var n=this.$form.find(".control-group"),r=this.$form.find(".editable-error-block"),i;if(t===!1)n.removeClass(e.fn.editableform.errorGroupClass),r.removeClass(e.fn.editableform.errorBlockClass).empty().hide();else{if(t){i=t.split("\n");for(var s=0;s<i.length;s++)i[s]=e("<div>").text(i[s]).html();t=i.join("<br>")}n.addClass(e.fn.editableform.errorGroupClass),r.addClass(e.fn.editableform.errorBlockClass).html(t).show()}},submit:function(t){t.stopPropagation(),t.preventDefault();var n,r=this.input.input2value();if(n=this.validate(r)){this.error(n),this.showForm();return}if(!this.options.savenochange&&this.input.value2str(r)==this.input.value2str(this.value)){this.$div.triggerHandler("nochange");return}var i=this.input.value2submit(r);this.isSaving=!0,e.when(this.save(i)).done(e.proxy(function(e){this.isSaving=!1;var t=typeof this.options.success=="function"?this.options.success.call(this.options.scope,e,r):null;if(t===!1){this.error(!1),this.showForm(!1);return}if(typeof t=="string"){this.error(t),this.showForm();return}t&&typeof t=="object"&&t.hasOwnProperty("newValue")&&(r=t.newValue),this.error(!1),this.value=r,this.$div.triggerHandler("save",{newValue:r,submitValue:i,response:e})},this)).fail(e.proxy(function(e){this.isSaving=!1;var t;typeof this.options.error=="function"?t=this.options.error.call(this.options.scope,e,r):t=typeof e=="string"?e:e.responseText||e.statusText||"Unknown error!",this.error(t),this.showForm()},this))},save:function(t){this.options.pk=e.fn.editableutils.tryParseJson(this.options.pk,!0);var n=typeof this.options.pk=="function"?this.options.pk.call(this.options.scope):this.options.pk,r=!!(typeof this.options.url=="function"||this.options.url&&(this.options.send==="always"||this.options.send==="auto"&&n!==null&&n!==undefined)),i;if(r)return this.showLoading(),i={name:this.options.name||"",value:t,pk:n},typeof this.options.params=="function"?i=this.options.params.call(this.options.scope,i):(this.options.params=e.fn.editableutils.tryParseJson(this.options.params,!0),e.extend(i,this.options.params)),typeof this.options.url=="function"?this.options.url.call(this.options.scope,i):e.ajax(e.extend({url:this.options.url,data:i,type:"POST"},this.options.ajaxOptions))},validate:function(e){e===undefined&&(e=this.value);if(typeof this.options.validate=="function")return this.options.validate.call(this.options.scope,e)},option:function(e,t){e in this.options&&(this.options[e]=t),e==="value"&&this.setValue(t)},setValue:function(e,t){t?this.value=this.input.str2value(e):this.value=e,this.$form&&this.$form.is(":visible")&&this.input.value2input(this.value)}},e.fn.editableform=function(n){var r=arguments;return this.each(function(){var i=e(this),s=i.data("editableform"),o=typeof n=="object"&&n;s||i.data("editableform",s=new t(this,o)),typeof n=="string"&&s[n].apply(s,Array.prototype.slice.call(r,1))})},e.fn.editableform.Constructor=t,e.fn.editableform.defaults={type:"text",url:null,params:null,name:null,pk:null,value:null,send:"auto",validate:null,success:null,error:null,ajaxOptions:null,showbuttons:!0,scope:null,savenochange:!1},e.fn.editableform.template='<form class="form-inline editableform"><div class="control-group"><div><div class="editable-input"></div><div class="editable-buttons"></div></div><div class="editable-error-block"></div></div></form>',e.fn.editableform.loading='<div class="editableform-loading"></div>',e.fn.editableform.buttons='<button type="submit" class="editable-submit">ok</button><button type="button" class="editable-cancel">cancel</button>',e.fn.editableform.errorGroupClass=null,e.fn.editableform.errorBlockClass="editable-error"})(window.jQuery),function(e){"use strict";e.fn.editableutils={inherit:function(e,t){var n=function(){};n.prototype=t.prototype,e.prototype=new n,e.prototype.constructor=e,e.superclass=t.prototype},setCursorPosition:function(e,t){if(e.setSelectionRange)e.setSelectionRange(t,t);else if(e.createTextRange){var n=e.createTextRange();n.collapse(!0),n.moveEnd("character",t),n.moveStart("character",t),n.select()}},tryParseJson:function(e,t){if(typeof e=="string"&&e.length&&e.match(/^[\{\[].*[\}\]]$/))if(t)try{e=(new Function("return "+e))()}catch(n){}finally{return e}else e=(new Function("return "+e))();return e},sliceObj:function(t,n,r){var i,s,o={};if(!e.isArray(n)||!n.length)return o;for(var u=0;u<n.length;u++){i=n[u],t.hasOwnProperty(i)&&(o[i]=t[i]);if(r===!0)continue;s=i.toLowerCase(),t.hasOwnProperty(s)&&(o[i]=t[s])}return o},getConfigData:function(t){var n={};return e.each(t.data(),function(e,t){if(typeof t!="object"||t&&typeof t=="object"&&(t.constructor===Object||t.constructor===Array))n[e]=t}),n},objectKeys:function(e){if(Object.keys)return Object.keys(e);if(e!==Object(e))throw new TypeError("Object.keys called on a non-object");var t=[],n;for(n in e)Object.prototype.hasOwnProperty.call(e,n)&&t.push(n);return t},escape:function(t){return e("<div>").text(t).html()},itemsByValue:function(t,n,r){if(!n||t===null)return[];r=r||"value";var i=e.isArray(t),s=[],o=this;return e.each(n,function(n,u){u.children?s=s.concat(o.itemsByValue(t,u.children,r)):i?e.grep(t,function(e){return e==(u&&typeof u==="object"?u[r]:u)}).length&&s.push(u):t==(u&&typeof u==="object"?u[r]:u)&&s.push(u)}),s},createInput:function(t){var n,r,i,s=t.type;return s==="date"&&(t.mode==="inline"?e.fn.editabletypes.datefield?s="datefield":e.fn.editabletypes.dateuifield&&(s="dateuifield"):e.fn.editabletypes.date?s="date":e.fn.editabletypes.dateui&&(s="dateui"),s==="date"&&!e.fn.editabletypes.date&&(s="combodate")),s==="datetime"&&t.mode==="inline"&&(s="datetimefield"),s==="wysihtml5"&&!e.fn.editabletypes[s]&&(s="textarea"),typeof e.fn.editabletypes[s]=="function"?(n=e.fn.editabletypes[s],r=this.sliceObj(t,this.objectKeys(n.defaults)),i=new n(r),i):(e.error("Unknown type: "+s),!1)},supportsTransitions:function(){var e=document.body||document.documentElement,t=e.style,n="transition",r=["Moz","Webkit","Khtml","O","ms"];if(typeof t[n]=="string")return!0;n=n.charAt(0).toUpperCase()+n.substr(1);for(var i=0;i<r.length;i++)if(typeof t[r[i]+n]=="string")return!0;return!1}}}(window.jQuery),function(e){"use strict";var t=function(e,t){this.init(e,t)},n=function(e,t){this.init(e,t)};t.prototype={containerName:null,innerCss:null,containerClass:"editable-container editable-popup",init:function(n,r){this.$element=e(n),this.options=e.extend({},e.fn.editableContainer.defaults,r),this.splitOptions(),this.formOptions.scope=this.$element[0],this.initContainer(),this.delayedHide=!1,this.$element.on("destroyed",e.proxy(function(){this.destroy()},this)),e(document).data("editable-handlers-attached")||(e(document).on("keyup.editable",function(t){t.which===27&&e(".editable-open").editableContainer("hide")}),e(document).on("click.editable",function(n){var r=e(n.target),i,s=[".editable-container",".ui-datepicker-header",".datepicker",".modal-backdrop",".bootstrap-wysihtml5-insert-image-modal",".bootstrap-wysihtml5-insert-link-modal"];if(!e.contains(document.documentElement,n.target))return;if(r.is(document))return;for(i=0;i<s.length;i++)if(r.is(s[i])||r.parents(s[i]).length)return;t.prototype.closeOthers(n.target)}),e(document).data("editable-handlers-attached",!0))},splitOptions:function(){this.containerOptions={},this.formOptions={};if(!e.fn[this.containerName])throw new Error(this.containerName+" not found. Have you included corresponding js file?");var t=e.fn[this.containerName].defaults;for(var n in this.options)n in t?this.containerOptions[n]=this.options[n]:this.formOptions[n]=this.options[n]},tip:function(){return this.container()?this.container().$tip:null},container:function(){return this.$element.data(this.containerDataName||this.containerName)},call:function(){this.$element[this.containerName].apply(this.$element,arguments)},initContainer:function(){this.call(this.containerOptions)},renderForm:function(){this.$form.editableform(this.formOptions).on({save:e.proxy(this.save,this),nochange:e.proxy(function(){this.hide("nochange")},this),cancel:e.proxy(function(){this.hide("cancel")},this),show:e.proxy(function(){this.delayedHide?(this.hide(this.delayedHide.reason),this.delayedHide=!1):this.setPosition()},this),rendering:e.proxy(this.setPosition,this),resize:e.proxy(this.setPosition,this),rendered:e.proxy(function(){this.$element.triggerHandler("shown",this)},this)}).editableform("render")},show:function(t){this.$element.addClass("editable-open"),t!==!1&&this.closeOthers(this.$element[0]),this.innerShow(),this.tip().addClass(this.containerClass),this.$form,this.$form=e("<div>"),this.tip().is(this.innerCss)?this.tip().append(this.$form):this.tip().find(this.innerCss).append(this.$form),this.renderForm()},hide:function(e){if(!this.tip()||!this.tip().is(":visible")||!this.$element.hasClass("editable-open"))return;if(this.$form.data("editableform").isSaving){this.delayedHide={reason:e};return}this.delayedHide=!1,this.$element.removeClass("editable-open"),this.innerHide(),this.$element.triggerHandler("hidden",e||"manual")},innerShow:function(){},innerHide:function(){},toggle:function(e){this.container()&&this.tip()&&this.tip().is(":visible")?this.hide():this.show(e)},setPosition:function(){},save:function(e,t){this.$element.triggerHandler("save",t),this.hide("save")},option:function(e,t){this.options[e]=t,e in this.containerOptions?(this.containerOptions[e]=t,this.setContainerOption(e,t)):(this.formOptions[e]=t,this.$form&&this.$form.editableform("option",e,t))},setContainerOption:function(e,t){this.call("option",e,t)},destroy:function(){this.hide(),this.innerDestroy(),this.$element.off("destroyed"),this.$element.removeData("editableContainer")},innerDestroy:function(){},closeOthers:function(t){e(".editable-open").each(function(n,r){if(r===t||e(r).find(t).length)return;var i=e(r),s=i.data("editableContainer");if(!s)return;s.options.onblur==="cancel"?i.data("editableContainer").hide("onblur"):s.options.onblur==="submit"&&i.data("editableContainer").tip().find("form").submit()})},activate:function(){this.tip&&this.tip().is(":visible")&&this.$form&&this.$form.data("editableform").input.activate()}},e.fn.editableContainer=function(r){var i=arguments;return this.each(function(){var s=e(this),o="editableContainer",u=s.data(o),a=typeof r=="object"&&r,f=a.mode==="inline"?n:t;u||s.data(o,u=new f(this,a)),typeof r=="string"&&u[r].apply(u,Array.prototype.slice.call(i,1))})},e.fn.editableContainer.Popup=t,e.fn.editableContainer.Inline=n,e.fn.editableContainer.defaults={value:null,placement:"top",autohide:!0,onblur:"cancel",anim:!1,mode:"popup"},jQuery.event.special.destroyed={remove:function(e){e.handler&&e.handler()}}}(window.jQuery),function(e){"use strict";e.extend(e.fn.editableContainer.Inline.prototype,e.fn.editableContainer.Popup.prototype,{containerName:"editableform",innerCss:".editable-inline",containerClass:"editable-container editable-inline",initContainer:function(){this.$tip=e("<span></span>"),this.options.anim||(this.options.anim=0)},splitOptions:function(){this.containerOptions={},this.formOptions=this.options},tip:function(){return this.$tip},innerShow:function(){this.$element.hide(),this.tip().insertAfter(this.$element).show()},innerHide:function(){this.$tip.hide(this.options.anim,e.proxy(function(){this.$element.show(),this.innerDestroy()},this))},innerDestroy:function(){this.tip()&&this.tip().empty().remove()}})}(window.jQuery),function(e){"use strict";var t=function(t,n){this.$element=e(t),this.options=e.extend({},e.fn.editable.defaults,n,e.fn.editableutils.getConfigData(this.$element)),this.options.selector?this.initLive():this.init(),this.options.highlight&&!e.fn.editableutils.supportsTransitions()&&(this.options.highlight=!1)};t.prototype={constructor:t,init:function(){var t=!1,n,r;this.options.name=this.options.name||this.$element.attr("id"),this.options.scope=this.$element[0],this.input=e.fn.editableutils.createInput(this.options);if(!this.input)return;this.options.value===undefined||this.options.value===null?(this.value=this.input.html2value(e.trim(this.$element.html())),t=!0):(this.options.value=e.fn.editableutils.tryParseJson(this.options.value,!0),typeof this.options.value=="string"?this.value=this.input.str2value(this.options.value):this.value=this.options.value),this.$element.addClass("editable"),this.options.toggle!=="manual"?(this.$element.addClass("editable-click"),this.$element.on(this.options.toggle+".editable",e.proxy(function(e){this.options.disabled||e.preventDefault();if(this.options.toggle==="mouseenter")this.show();else{var t=this.options.toggle!=="click";this.toggle(t)}},this))):this.$element.attr("tabindex",-1),typeof this.options.display=="function"&&(this.options.autotext="always");switch(this.options.autotext){case"always":n=!0;break;case"auto":n=!e.trim(this.$element.text()).length&&this.value!==null&&this.value!==undefined&&!t;break;default:n=!1}e.when(n?this.render():!0).then(e.proxy(function(){this.options.disabled?this.disable():this.enable(),this.$element.triggerHandler("init",this)},this))},initLive:function(){var t=this.options.selector;this.options.selector=!1,this.options.autotext="never",this.$element.on(this.options.toggle+".editable",t,e.proxy(function(t){var n=e(t.target);n.data("editable")||(n.hasClass(this.options.emptyclass)&&n.empty(),n.editable(this.options).trigger(t))},this))},render:function(e){if(this.options.display===!1)return;return this.input.value2htmlFinal?this.input.value2html(this.value,this.$element[0],this.options.display,e):typeof this.options.display=="function"?this.options.display.call(this.$element[0],this.value,e):this.input.value2html(this.value,this.$element[0])},enable:function(){this.options.disabled=!1,this.$element.removeClass("editable-disabled"),this.handleEmpty(this.isEmpty),this.options.toggle!=="manual"&&this.$element.attr("tabindex")==="-1"&&this.$element.removeAttr("tabindex")},disable:function(){this.options.disabled=!0,this.hide(),this.$element.addClass("editable-disabled"),this.handleEmpty(this.isEmpty),this.$element.attr("tabindex",-1)},toggleDisabled:function(){this.options.disabled?this.enable():this.disable()},option:function(t,n){if(t&&typeof t=="object"){e.each(t,e.proxy(function(t,n){this.option(e.trim(t),n)},this));return}this.options[t]=n;if(t==="disabled")return n?this.disable():this.enable();t==="value"&&this.setValue(n),this.container&&this.container.option(t,n),this.input.option&&this.input.option(t,n)},handleEmpty:function(t){if(this.options.display===!1)return;t!==undefined?this.isEmpty=t:e.trim(this.$element.html())===""?this.isEmpty=!0:e.trim(this.$element.text())!==""?this.isEmpty=!1:this.isEmpty=!this.$element.height()||!this.$element.width(),this.options.disabled?this.isEmpty&&(this.$element.empty(),this.options.emptyclass&&this.$element.removeClass(this.options.emptyclass)):this.isEmpty?(this.$element.html(this.options.emptytext),this.options.emptyclass&&this.$element.addClass(this.options.emptyclass)):this.options.emptyclass&&this.$element.removeClass(this.options.emptyclass)},show:function(t){if(this.options.disabled)return;if(!this.container){var n=e.extend({},this.options,{value:this.value,input:this.input});this.$element.editableContainer(n),this.$element.on("save.internal",e.proxy(this.save,this)),this.container=this.$element.data("editableContainer")}else if(this.container.tip().is(":visible"))return;this.container.show(t)},hide:function(){this.container&&this.container.hide()},toggle:function(e){this.container&&this.container.tip().is(":visible")?this.hide():this.show(e)},save:function(e,t){if(this.options.unsavedclass){var n=!1;n=n||typeof this.options.url=="function",n=n||this.options.display===!1,n=n||t.response!==undefined,n=n||this.options.savenochange&&this.input.value2str(this.value)!==this.input.value2str(t.newValue),n?this.$element.removeClass(this.options.unsavedclass):this.$element.addClass(this.options.unsavedclass)}if(this.options.highlight){var r=this.$element,i=r.css("background-color");r.css("background-color",this.options.highlight),setTimeout(function(){r.css("background-color",i),r.addClass("editable-bg-transition"),setTimeout(function(){r.removeClass("editable-bg-transition")},1700)},0)}this.setValue(t.newValue,!1,t.response)},validate:function(){if(typeof this.options.validate=="function")return this.options.validate.call(this,this.value)},setValue:function(t,n,r){n?this.value=this.input.str2value(t):this.value=t,this.container&&this.container.option("value",this.value),e.when(this.render(r)).then(e.proxy(function(){this.handleEmpty()},this))},activate:function(){this.container&&this.container.activate()},destroy:function(){this.disable(),this.container&&this.container.destroy(),this.input.destroy(),this.options.toggle!=="manual"&&(this.$element.removeClass("editable-click"),this.$element.off(this.options.toggle+".editable")),this.$element.off("save.internal"),this.$element.removeClass("editable editable-open editable-disabled"),this.$element.removeData("editable")}},e.fn.editable=function(n){var r={},i=arguments,s="editable";switch(n){case"validate":return this.each(function(){var t=e(this),n=t.data(s),i;n&&(i=n.validate())&&(r[n.options.name]=i)}),r;case"getValue":return arguments.length===2&&arguments[1]===!0?r=this.eq(0).data(s).value:this.each(function(){var t=e(this),n=t.data(s);n&&n.value!==undefined&&n.value!==null&&(r[n.options.name]=n.input.value2submit(n.value))}),r;case"submit":var o=arguments[1]||{},u=this,a=this.editable("validate"),f;return e.isEmptyObject(a)?(f=this.editable("getValue"),o.data&&e.extend(f,o.data),e.ajax(e.extend({url:o.url,data:f,type:"POST"},o.ajaxOptions)).success(function(e){typeof o.success=="function"&&o.success.call(u,e,o)}).error(function(){typeof o.error=="function"&&o.error.apply(u,arguments)})):typeof o.error=="function"&&o.error.call(u,a),this}return this.each(function(){var r=e(this),o=r.data(s),u=typeof n=="object"&&n;o||r.data(s,o=new t(this,u)),typeof n=="string"&&o[n].apply(o,Array.prototype.slice.call(i,1))})},e.fn.editable.defaults={type:"text",disabled:!1,toggle:"click",emptytext:"Empty",autotext:"auto",value:null,display:null,emptyclass:"editable-empty",unsavedclass:"editable-unsaved",selector:null,highlight:"#FFFF80"}}(window.jQuery),function(e){"use strict";e.fn.editabletypes={};var t=function(){};t.prototype={init:function(t,n,r){this.type=t,this.options=e.extend({},r,n)},prerender:function(){this.$tpl=e(this.options.tpl),this.$input=this.$tpl,this.$clear=null,this.error=null},render:function(){},value2html:function(t,n){e(n).text(e.trim(t))},html2value:function(t){return e("<div>").html(t).text()},value2str:function(e){return e},str2value:function(e){return e},value2submit:function(e){return e},value2input:function(e){this.$input.val(e)},input2value:function(){return this.$input.val()},activate:function(){this.$input.is(":visible")&&this.$input.focus()},clear:function(){this.$input.val(null)},escape:function(t){return e("<div>").text(t).html()},autosubmit:function(){},destroy:function(){},setClass:function(){this.options.inputclass&&this.$input.addClass(this.options.inputclass)},setAttr:function(e){this.options[e]!==undefined&&this.options[e]!==null&&this.$input.attr(e,this.options[e])},option:function(e,t){this.options[e]=t}},t.defaults={tpl:"",inputclass:"input-medium",scope:null,showbuttons:!0},e.extend(e.fn.editabletypes,{abstractinput:t})}(window.jQuery),function(e){"use strict";var t=function(e){};e.fn.editableutils.inherit(t,e.fn.editabletypes.abstractinput),e.extend(t.prototype,{render:function(){var t=e.Deferred();return this.error=null,this.onSourceReady(function(){this.renderList(),t.resolve()},function(){this.error=this.options.sourceError,t.resolve()}),t.promise()},html2value:function(e){return null},value2html:function(t,n,r,i){var s=e.Deferred(),o=function(){typeof r=="function"?r.call(n,t,this.sourceData,i):this.value2htmlFinal(t,n),s.resolve()};return t===null?o.call(this):this.onSourceReady(o,function(){s.resolve()}),s.promise()},onSourceReady:function(t,n){var r;e.isFunction(this.options.source)?(r=this.options.source.call(this.options.scope),this.sourceData=null):r=this.options.source;if(this.options.sourceCache&&e.isArray(this.sourceData)){t.call(this);return}try{r=e.fn.editableutils.tryParseJson(r,!1)}catch(i){n.call(this);return}if(typeof r=="string"){if(this.options.sourceCache){var s=r,o;e(document).data(s)||e(document).data(s,{}),o=e(document).data(s);if(o.loading===!1&&o.sourceData){this.sourceData=o.sourceData,this.doPrepend(),t.call(this);return}if(o.loading===!0){o.callbacks.push(e.proxy(function(){this.sourceData=o.sourceData,this.doPrepend(),t.call(this)},this)),o.err_callbacks.push(e.proxy(n,this));return}o.loading=!0,o.callbacks=[],o.err_callbacks=[]}e.ajax({url:r,type:"get",cache:!1,dataType:"json",success:e.proxy(function(r){o&&(o.loading=!1),this.sourceData=this.makeArray(r),e.isArray(this.sourceData)?(o&&(o.sourceData=this.sourceData,e.each(o.callbacks,function(){this.call()})),this.doPrepend(),t.call(this)):(n.call(this),o&&e.each(o.err_callbacks,function(){this.call()}))},this),error:e.proxy(function(){n.call(this),o&&(o.loading=!1,e.each(o.err_callbacks,function(){this.call()}))},this)})}else this.sourceData=this.makeArray(r),e.isArray(this.sourceData)?(this.doPrepend(),t.call(this)):n.call(this)},doPrepend:function(){if(this.options.prepend===null||this.options.prepend===undefined)return;e.isArray(this.prependData)||(e.isFunction(this.options.prepend)&&(this.options.prepend=this.options.prepend.call(this.options.scope)),this.options.prepend=e.fn.editableutils.tryParseJson(this.options.prepend,!0),typeof this.options.prepend=="string"&&(this.options.prepend={"":this.options.prepend}),this.prependData=this.makeArray(this.options.prepend)),e.isArray(this.prependData)&&e.isArray(this.sourceData)&&(this.sourceData=this.prependData.concat(this.sourceData))},renderList:function(){},value2htmlFinal:function(e,t){},makeArray:function(t){var n,r,i=[],s,o;if(!t||typeof t=="string")return null;if(e.isArray(t)){o=function(e,t){r={value:e,text:t};if(n++>=2)return!1};for(var u=0;u<t.length;u++)s=t[u],typeof s=="object"?(n=0,e.each(s,o),n===1?i.push(r):n>1&&(s.children&&(s.children=this.makeArray(s.children)),i.push(s))):i.push({value:s,text:s})}else e.each(t,function(e,t){i.push({value:e,text:t})});return i},option:function(e,t){this.options[e]=t,e==="source"&&(this.sourceData=null),e==="prepend"&&(this.prependData=null)}}),t.defaults=e.extend({},e.fn.editabletypes.abstractinput.defaults,{source:null,prepend:!1,sourceError:"Error when loading list",sourceCache:!0}),e.fn.editabletypes.list=t}(window.jQuery),function(e){"use strict";var t=function(e){this.init("text",e,t.defaults)};e.fn.editableutils.inherit(t,e.fn.editabletypes.abstractinput),e.extend(t.prototype,{render:function(){this.renderClear(),this.setClass(),this.setAttr("placeholder")},activate:function(){this.$input.is(":visible")&&(this.$input.focus(),e.fn.editableutils.setCursorPosition(this.$input.get(0),this.$input.val().length),this.toggleClear&&this.toggleClear())},renderClear:function(){this.options.clear&&(this.$clear=e('<span class="editable-clear-x"></span>'),this.$input.after(this.$clear).css("padding-right",24).keyup(e.proxy(function(t){if(~e.inArray(t.keyCode,[40,38,9,13,27]))return;clearTimeout(this.t);var n=this;this.t=setTimeout(function(){n.toggleClear(t)},100)},this)).parent().css("position","relative"),this.$clear.click(e.proxy(this.clear,this)))},postrender:function(){},toggleClear:function(e){if(!this.$clear)return;var t=this.$input.val().length,n=this.$clear.is(":visible");t&&!n&&this.$clear.show(),!t&&n&&this.$clear.hide()},clear:function(){this.$clear.hide(),this.$input.val("").focus()}}),t.defaults=e.extend({},e.fn.editabletypes.abstractinput.defaults,{tpl:'<input type="text">',placeholder:null,clear:!0}),e.fn.editabletypes.text=t}(window.jQuery),function(e){"use strict";var t=function(e){this.init("textarea",e,t.defaults)};e.fn.editableutils.inherit(t,e.fn.editabletypes.abstractinput),e.extend(t.prototype,{render:function(){this.setClass(),this.setAttr("placeholder"),this.setAttr("rows"),this.$input.keydown(function(t){t.ctrlKey&&t.which===13&&e(this).closest("form").submit()})},value2html:function(t,n){var r="",i;if(t){i=t.split("\n");for(var s=0;s<i.length;s++)i[s]=e("<div>").text(i[s]).html();r=i.join("<br>")}e(n).html(r)},html2value:function(t){if(!t)return"";var n=new RegExp(String.fromCharCode(10),"g"),r=t.split(/<br\s*\/?>/i);for(var i=0;i<r.length;i++){var s=e("<div>").html(r[i]).text();s=s.replace(n,""),r[i]=s}return r.join("\n")},activate:function(){e.fn.editabletypes.text.prototype.activate.call(this)}}),t.defaults=e.extend({},e.fn.editabletypes.abstractinput.defaults,{tpl:"<textarea></textarea>",inputclass:"input-large",placeholder:null,rows:7}),e.fn.editabletypes.textarea=t}(window.jQuery),function(e){"use strict";var t=function(e){this.init("select",e,t.defaults)};e.fn.editableutils.inherit(t,e.fn.editabletypes.list),e.extend(t.prototype,{renderList:function(){this.$input.empty();var t=function(n,r){if(e.isArray(r))for(var i=0;i<r.length;i++)r[i].children?n.append(t(e("<optgroup>",{label:r[i].text}),r[i].children)):n.append(e("<option>",{value:r[i].value}).text(r[i].text));return n};t(this.$input,this.sourceData),this.setClass(),this.$input.on("keydown.editable",function(t){t.which===13&&e(this).closest("form").submit()})},value2htmlFinal:function(t,n){var r="",i=e.fn.editableutils.itemsByValue(t,this.sourceData);i.length&&(r=i[0].text),e(n).text(r)},autosubmit:function(){this.$input.off("keydown.editable").on("change.editable",function(){e(this).closest("form").submit()})}}),t.defaults=e.extend({},e.fn.editabletypes.list.defaults,{tpl:"<select></select>"}),e.fn.editabletypes.select=t}(window.jQuery),function(e){"use strict";var t=function(e){this.init("checklist",e,t.defaults)};e.fn.editableutils.inherit(t,e.fn.editabletypes.list),e.extend(t.prototype,{renderList:function(){var t,n;this.$tpl.empty();if(!e.isArray(this.sourceData))return;for(var r=0;r<this.sourceData.length;r++)t=e("<label>").append(e("<input>",{type:"checkbox",value:this.sourceData[r].value})).append(e("<span>").text(" "+this.sourceData[r].text)),e("<div>").append(t).appendTo(this.$tpl);this.$input=this.$tpl.find('input[type="checkbox"]'),this.setClass()},value2str:function(t){return e.isArray(t)?t.sort().join(e.trim(this.options.separator)):""},str2value:function(t){var n,r=null;return typeof t=="string"&&t.length?(n=new RegExp("\\s*"+e.trim(this.options.separator)+"\\s*"),r=t.split(n)):e.isArray(t)?r=t:r=[t],r},value2input:function(t){this.$input.prop("checked",!1),e.isArray(t)&&t.length&&this.$input.each(function(n,r){var i=e(r);e.each(t,function(e,t){i.val()==t&&i.prop("checked",!0)})})},input2value:function(){var t=[];return this.$input.filter(":checked").each(function(n,r){t.push(e(r).val())}),t},value2htmlFinal:function(t,n){var r=[],i=e.fn.editableutils.itemsByValue(t,this.sourceData);i.length?(e.each(i,function(t,n){r.push(e.fn.editableutils.escape(n.text))}),e(n).html(r.join("<br>"))):e(n).empty()},activate:function(){this.$input.first().focus()},autosubmit:function(){this.$input.on("keydown",function(t){t.which===13&&e(this).closest("form").submit()})}}),t.defaults=e.extend({},e.fn.editabletypes.list.defaults,{tpl:'<div class="editable-checklist"></div>',inputclass:null,separator:","}),e.fn.editabletypes.checklist=t}(window.jQuery),function(e){"use strict";var t=function(e){this.init("password",e,t.defaults)};e.fn.editableutils.inherit(t,e.fn.editabletypes.text),e.extend(t.prototype,{value2html:function(t,n){t?e(n).text("[hidden]"):e(n).empty()},html2value:function(e){return null}}),t.defaults=e.extend({},e.fn.editabletypes.text.defaults,{tpl:'<input type="password">'}),e.fn.editabletypes.password=t}(window.jQuery),function(e){"use strict";var t=function(e){this.init("email",e,t.defaults)};e.fn.editableutils.inherit(t,e.fn.editabletypes.text),t.defaults=e.extend({},e.fn.editabletypes.text.defaults,{tpl:'<input type="email">'}),e.fn.editabletypes.email=t}(window.jQuery),function(e){"use strict";var t=function(e){this.init("url",e,t.defaults)};e.fn.editableutils.inherit(t,e.fn.editabletypes.text),t.defaults=e.extend({},e.fn.editabletypes.text.defaults,{tpl:'<input type="url">'}),e.fn.editabletypes.url=t}(window.jQuery),function(e){"use strict";var t=function(e){this.init("tel",e,t.defaults)};e.fn.editableutils.inherit(t,e.fn.editabletypes.text),t.defaults=e.extend({},e.fn.editabletypes.text.defaults,{tpl:'<input type="tel">'}),e.fn.editabletypes.tel=t}(window.jQuery),function(e){"use strict";var t=function(e){this.init("number",e,t.defaults)};e.fn.editableutils.inherit(t,e.fn.editabletypes.text),e.extend(t.prototype,{render:function(){t.superclass.render.call(this),this.setAttr("min"),this.setAttr("max"),this.setAttr("step")},postrender:function(){this.$clear&&this.$clear.css({right:24})}}),t.defaults=e.extend({},e.fn.editabletypes.text.defaults,{tpl:'<input type="number">',inputclass:"input-mini",min:null,max:null,step:null}),e.fn.editabletypes.number=t}(window.jQuery),function(e){"use strict";var t=function(e){this.init("range",e,t.defaults)};e.fn.editableutils.inherit(t,e.fn.editabletypes.number),e.extend(t.prototype,{render:function(){this.$input=this.$tpl.filter("input"),this.setClass(),this.setAttr("min"),this.setAttr("max"),this.setAttr("step"),this.$input.on("input",function(){e(this).siblings("output").text(e(this).val())})},activate:function(){this.$input.focus()}}),t.defaults=e.extend({},e.fn.editabletypes.number.defaults,{tpl:'<input type="range"><output style="width: 30px; display: inline-block"></output>',inputclass:"input-medium"}),e.fn.editabletypes.range=t}(window.jQuery),function(e){"use strict";var t=function(n){this.init("select2",n,t.defaults),n.select2=n.select2||{},this.sourceData=null,n.placeholder&&(n.select2.placeholder=n.placeholder);if(!n.select2.tags&&n.source){var r=n.source;e.isFunction(n.source)&&(r=n.source.call(n.scope)),typeof r=="string"?(n.select2.ajax=n.select2.ajax||{},n.select2.ajax.data||(n.select2.ajax.data=function(e){return{query:e}}),n.select2.ajax.results||(n.select2.ajax.results=function(e){return{results:e}}),n.select2.ajax.url=r):(this.sourceData=this.convertSource(r),n.select2.data=this.sourceData)}this.options.select2=e.extend({},t.defaults.select2,n.select2),this.isMultiple=this.options.select2.tags||this.options.select2.multiple,this.isRemote="ajax"in this.options.select2};e.fn.editableutils.inherit(t,e.fn.editabletypes.abstractinput),e.extend(t.prototype,{render:function(){this.setClass(),this.$input.select2(this.options.select2),this.isRemote&&this.$input.on("select2-loaded",e.proxy(function(e){this.sourceData=e.items.results},this)),this.isMultiple&&this.$input.on("change",function(){e(this).closest("form").parent().triggerHandler("resize")})},value2html:function(t,n){var r="",i;this.options.select2.tags?i=t:this.sourceData&&(i=e.fn.editableutils.itemsByValue(t,this.sourceData,"id")),e.isArray(i)?(r=[],e.each(i,function(e,t){r.push(t&&typeof t=="object"?t.text:t)})):i&&(r=i.text),r=e.isArray(r)?r.join(this.options.viewseparator):r,e(n).text(r)},html2value:function(e){return this.options.select2.tags?this.str2value(e,this.options.viewseparator):null},value2input:function(t){if(this.isRemote){var n,r;this.sourceData&&(r=e.fn.editableutils.itemsByValue(t,this.sourceData,"id"),r.length&&(n=r[0])),n||(n={id:t,text:e(this.options.scope).text()}),this.$input.select2("data",n).trigger("change",!0)}else this.$input.val(t).trigger("change",!0)},input2value:function(){return this.$input.select2("val")},str2value:function(t,n){if(typeof t!="string"||!this.isMultiple)return t;n=n||this.options.select2.separator||e.fn.select2.defaults.separator;var r,i,s;if(t===null||t.length<1)return null;r=t.split(n);for(i=0,s=r.length;i<s;i+=1)r[i]=e.trim(r[i]);return r},autosubmit:function(){this.$input.on("change",function(t,n){n||e(this).closest("form").submit()})},convertSource:function(t){if(e.isArray(t)&&t.length&&t[0].value!==undefined)for(var n=0;n<t.length;n++)t[n].value!==undefined&&(t[n].id=t[n].value,delete t[n].value);return t}}),t.defaults=e.extend({},e.fn.editabletypes.abstractinput.defaults,{tpl:'<input type="hidden">',select2:null,placeholder:null,source:null,viewseparator:", "}),e.fn.editabletypes.select2=t}(window.jQuery),function(e){var t=function(t,n){this.$element=e(t);if(!this.$element.is("input")){e.error("Combodate should be applied to INPUT element");return}this.options=e.extend({},e.fn.combodate.defaults,n,this.$element.data()),this.init()};t.prototype={constructor:t,init:function(){this.map={day:["D","date"],month:["M","month"],year:["Y","year"],hour:["[Hh]","hours"],minute:["m","minutes"],second:["s","seconds"],ampm:["[Aa]",""]},this.$widget=e('<span class="combodate"></span>').html(this.getTemplate()),this.initCombos(),this.$widget.on("change","select",e.proxy(function(){this.$element.val(this.getValue())},this)),this.$widget.find("select").css("width","auto"),this.$element.hide().after(this.$widget),this.setValue(this.$element.val()||this.options.value)},getTemplate:function(){var t=this.options.template;return e.each(this.map,function(e,n){n=n[0];var r=new RegExp(n+"+"),i=n.length>1?n.substring(1,2):n;t=t.replace(r,"{"+i+"}")}),t=t.replace(/ /g,"&nbsp;"),e.each(this.map,function(e,n){n=n[0];var r=n.length>1?n.substring(1,2):n;t=t.replace("{"+r+"}",'<select class="'+e+'"></select>')}),t},initCombos:function(){var t=this;e.each(this.map,function(e,n){var r=t.$widget.find("."+e),i,s;r.length&&(t["$"+e]=r,i="fill"+e.charAt(0).toUpperCase()+e.slice(1),s=t[i](),t["$"+e].html(t.renderItems(s)))})},initItems:function(e){var t=[],n;if(this.options.firstItem==="name"){n=moment.relativeTime||moment.langData()._relativeTime;var r=typeof n[e]=="function"?n[e](1,!0,e,!1):n[e];r=r.split(" ").reverse()[0],t.push(["",r])}else this.options.firstItem==="empty"&&t.push(["",""]);return t},renderItems:function(e){var t=[];for(var n=0;n<e.length;n++)t.push('<option value="'+e[n][0]+'">'+e[n][1]+"</option>");return t.join("\n")},fillDay:function(){var e=this.initItems("d"),t,n,r=this.options.template.indexOf("DD")!==-1;for(n=1;n<=31;n++)t=r?this.leadZero(n):n,e.push([n,t]);return e},fillMonth:function(){var e=this.initItems("M"),t,n,r=this.options.template.indexOf("MMMM")!==-1,i=this.options.template.indexOf("MMM")!==-1,s=this.options.template.indexOf("MM")!==-1;for(n=0;n<=11;n++)r?t=moment().date(1).month(n).format("MMMM"):i?t=moment().date(1).month(n).format("MMM"):s?t=this.leadZero(n+1):t=n+1,e.push([n,t]);return e},fillYear:function(){var e=[],t,n,r=this.options.template.indexOf("YYYY")!==-1;for(n=this.options.maxYear;n>=this.options.minYear;n--)t=r?n:(n+"").substring(2),e[this.options.yearDescending?"push":"unshift"]([n,t]);return e=this.initItems("y").concat(e),e},fillHour:function(){var e=this.initItems("h"),t,n,r=this.options.template.indexOf("h")!==-1,i=this.options.template.indexOf("H")!==-1,s=this.options.template.toLowerCase().indexOf("hh")!==-1,o=r?1:0,u=r?12:23;for(n=o;n<=u;n++)t=s?this.leadZero(n):n,e.push([n,t]);return e},fillMinute:function(){var e=this.initItems("m"),t,n,r=this.options.template.indexOf("mm")!==-1;for(n=0;n<=59;n+=this.options.minuteStep)t=r?this.leadZero(n):n,e.push([n,t]);return e},fillSecond:function(){var e=this.initItems("s"),t,n,r=this.options.template.indexOf("ss")!==-1;for(n=0;n<=59;n+=this.options.secondStep)t=r?this.leadZero(n):n,e.push([n,t]);return e},fillAmpm:function(){var e=this.options.template.indexOf("a")!==-1,t=this.options.template.indexOf("A")!==-1,n=[["am",e?"am":"AM"],["pm",e?"pm":"PM"]];return n},getValue:function(t){var n,r={},i=this,s=!1;return e.each(this.map,function(e,t){if(e==="ampm")return;var n=e==="day"?1:0;r[e]=i["$"+e]?parseInt(i["$"+e].val(),10):n;if(isNaN(r[e]))return s=!0,!1}),s?"":(this.$ampm&&(r.hour===12?r.hour=this.$ampm.val()==="am"?0:12:r.hour=this.$ampm.val()==="am"?r.hour:r.hour+12),n=moment([r.year,r.month,r.day,r.hour,r.minute,r.second]),this.highlight(n),t=t===undefined?this.options.format:t,t===null?n.isValid()?n:null:n.isValid()?n.format(t):"")},setValue:function(t){function s(t,n){var r={};return t.children("option").each(function(t,i){var s=e(i).attr("value"),o;if(s==="")return;o=Math.abs(s-n);if(typeof r.distance=="undefined"||o<r.distance)r={value:s,distance:o}}),r.value}if(!t)return;var n=typeof t=="string"?moment(t,this.options.format):moment(t),r=this,i={};n.isValid()&&(e.each(this.map,function(e,t){if(e==="ampm")return;i[e]=n[t[1]]()}),this.$ampm&&(i.hour>=12?(i.ampm="pm",i.hour>12&&(i.hour-=12)):(i.ampm="am",i.hour===0&&(i.hour=12))),e.each(i,function(e,t){r["$"+e]&&(e==="minute"&&r.options.minuteStep>1&&r.options.roundTime&&(t=s(r["$"+e],t)),e==="second"&&r.options.secondStep>1&&r.options.roundTime&&(t=s(r["$"+e],t)),r["$"+e].val(t))}),this.$element.val(n.format(this.options.format)))},highlight:function(e){e.isValid()?this.options.errorClass?this.$widget.removeClass(this.options.errorClass):this.$widget.find("select").css("border-color",this.borderColor):this.options.errorClass?this.$widget.addClass(this.options.errorClass):(this.borderColor||(this.borderColor=this.$widget.find("select").css("border-color")),this.$widget.find("select").css("border-color","red"))},leadZero:function(e){return e<=9?"0"+e:e},destroy:function(){this.$widget.remove(),this.$element.removeData("combodate").show()}},e.fn.combodate=function(n){var r,i=Array.apply(null,arguments);return i.shift(),n==="getValue"&&this.length&&(r=this.eq(0).data("combodate"))?r.getValue.apply(r,i):this.each(function(){var r=e(this),s=r.data("combodate"),o=typeof n=="object"&&n;s||r.data("combodate",s=new t(this,o)),typeof n=="string"&&typeof s[n]=="function"&&s[n].apply(s,i)})},e.fn.combodate.defaults={format:"DD-MM-YYYY HH:mm",template:"D / MMM / YYYY   H : mm",value:null,minYear:1970,maxYear:2015,yearDescending:!0,minuteStep:5,secondStep:1,firstItem:"empty",errorClass:null,roundTime:!0}}(window.jQuery),function(e){"use strict";var t=function(n){this.init("combodate",n,t.defaults),this.options.viewformat||(this.options.viewformat=this.options.format),n.combodate=e.fn.editableutils.tryParseJson(n.combodate,!0),this.options.combodate=e.extend({},t.defaults.combodate,n.combodate,{format:this.options.format,template:this.options.template})};e.fn.editableutils.inherit(t,e.fn.editabletypes.abstractinput),e.extend(t.prototype,{render:function(){this.$input.combodate(this.options.combodate)},value2html:function(t,n){var r=t?t.format(this.options.viewformat):"";e(n).text(r)},html2value:function(e){return e?moment(e,this.options.viewformat):null},value2str:function(e){return e?e.format(this.options.format):""},str2value:function(e){return e?moment(e,this.options.format):null},value2submit:function(e){return this.value2str(e)},value2input:function(e){this.$input.combodate("setValue",e)},input2value:function(){return this.$input.combodate("getValue",null)},activate:function(){this.$input.siblings(".combodate").find("select").eq(0).focus()},autosubmit:function(){}}),t.defaults=e.extend({},e.fn.editabletypes.abstractinput.defaults,{tpl:'<input type="text">',inputclass:null,format:"YYYY-MM-DD",viewformat:null,template:"D / MMM / YYYY",combodate:null}),e.fn.editabletypes.combodate=t}(window.jQuery),function(e){"use strict";e.extend(e.fn.editableform.Constructor.prototype,{initTemplate:function(){this.$form=e(e.fn.editableform.template),this.$form.find(".editable-error-block").addClass("help-block")}}),e.fn.editableform.buttons='<button type="submit" class="btn btn-primary editable-submit"><i class="icon-ok icon-white"></i></button><button type="button" class="btn editable-cancel"><i class="icon-remove"></i></button>',e.fn.editableform.errorGroupClass="error",e.fn.editableform.errorBlockClass=null}(window.jQuery),function(e){"use strict";e.extend(e.fn.editableContainer.Popup.prototype,{containerName:"popover",innerCss:e.fn.popover&&e(e.fn.popover.defaults.template).find("p").length?".popover-content p":".popover-content",initContainer:function(){e.extend(this.containerOptions,{trigger:"manual",selector:!1,content:" ",template:e.fn.popover.defaults.template});var t;this.$element.data("template")&&(t=this.$element.data("template"),this.$element.removeData("template")),this.call(this.containerOptions),t&&this.$element.data("template",t)},innerShow:function(){this.call("show")},innerHide:function(){this.call("hide")},innerDestroy:function(){this.call("destroy")},setContainerOption:function(e,t){this.container().options[e]=t},setPosition:function(){(function(){var e=this.tip(),t,n,r,i,s,o;s=typeof this.options.placement=="function"?this.options.placement.call(this,e[0],this.$element[0]):this.options.placement,t=/in/.test(s),e.removeClass("top right bottom left").css({top:0,left:0,display:"block"}),n=this.getPosition(t),r=e[0].offsetWidth,i=e[0].offsetHeight;switch(t?s.split(" ")[1]:s){case"bottom":o={top:n.top+n.height,left:n.left+n.width/2-r/2};break;case"top":o={top:n.top-i,left:n.left+n.width/2-r/2};break;case"left":o={top:n.top+n.height/2-i/2,left:n.left-r};break;case"right":o={top:n.top+n.height/2-i/2,left:n.left+n.width}}e.offset(o).addClass(s).addClass("in")}).call(this.container())}})}(window.jQuery),function(e){function t(){return new Date(Date.UTC.apply(Date,arguments))}function n(){var e=new Date;return t(e.getUTCFullYear(),e.getUTCMonth(),e.getUTCDate())}function s(t,n){var r=e(t).data(),i={},s,o=new RegExp("^"+n.toLowerCase()+"([A-Z])"),n=new RegExp("^"+n.toLowerCase());for(var u in r)n.test(u)&&(s=u.replace(o,function(e,t){return t.toLowerCase()}),i[s]=r[u]);return i}function o(t){var n={};if(!c[t]){t=t.split("-")[0];if(!c[t])return}var r=c[t];return e.each(l,function(e,t){t in r&&(n[t]=r[t])}),n}var r=function(t,n){var r=this;this._process_options(n),this.element=e(t),this.isInline=!1,this.isInput=this.element.is("input"),this.component=this.element.is(".date")?this.element.find(".add-on, .btn"):!1,this.hasInput=this.component&&this.element.find("input").length,this.component&&this.component.length===0&&(this.component=!1),this.picker=e(h.template),this._buildEvents(),this._attachEvents(),this.isInline?this.picker.addClass("datepicker-inline").appendTo(this.element):this.picker.addClass("datepicker-dropdown dropdown-menu"),this.o.rtl&&(this.picker.addClass("datepicker-rtl"),this.picker.find(".prev i, .next i").toggleClass("icon-arrow-left icon-arrow-right")),this.viewMode=this.o.startView,this.o.calendarWeeks&&this.picker.find("tfoot th.today").attr("colspan",function(e,t){return parseInt(t)+1}),this._allow_update=!1,this.setStartDate(this.o.startDate),this.setEndDate(this.o.endDate),this.setDaysOfWeekDisabled(this.o.daysOfWeekDisabled),this.fillDow(),this.fillMonths(),this._allow_update=!0,this.update(),this.showMode(),this.isInline&&this.show()};r.prototype={constructor:r,_process_options:function(t){this._o=e.extend({},this._o,t);var n=this.o=e.extend({},this._o),r=n.language;c[r]||(r=r.split("-")[0],c[r]||(r=f.language)),n.language=r;switch(n.startView){case 2:case"decade":n.startView=2;break;case 1:case"year":n.startView=1;break;default:n.startView=0}switch(n.minViewMode){case 1:case"months":n.minViewMode=1;break;case 2:case"years":n.minViewMode=2;break;default:n.minViewMode=0}n.startView=Math.max(n.startView,n.minViewMode),n.weekStart%=7,n.weekEnd=(n.weekStart+6)%7;var i=h.parseFormat(n.format);n.startDate!==-Infinity&&(n.startDate=h.parseDate(n.startDate,i,n.language)),n.endDate!==Infinity&&(n.endDate=h.parseDate(n.endDate,i,n.language)),n.daysOfWeekDisabled=n.daysOfWeekDisabled||[],e.isArray(n.daysOfWeekDisabled)||(n.daysOfWeekDisabled=n.daysOfWeekDisabled.split(/[,\s]*/)),n.daysOfWeekDisabled=e.map(n.daysOfWeekDisabled,function(e){return parseInt(e,10)})},_events:[],_secondaryEvents:[],_applyEvents:function(e){for(var t=0,n,r;t<e.length;t++)n=e[t][0],r=e[t][1],n.on(r)},_unapplyEvents:function(e){for(var t=0,n,r;t<e.length;t++)n=e[t][0],r=e[t][1],n.off(r)},_buildEvents:function(){this.isInput?this._events=[[this.element,{focus:e.proxy(this.show,this),keyup:e.proxy(this.update,this),keydown:e.proxy(this.keydown,this)}]]:this.component&&this.hasInput?this._events=[[this.element.find("input"),{focus:e.proxy(this.show,this),keyup:e.proxy(this.update,this),keydown:e.proxy(this.keydown,this)}],[this.component,{click:e.proxy(this.show,this)}]]:this.element.is("div")?this.isInline=!0:this._events=[[this.element,{click:e.proxy(this.show,this)}]],this._secondaryEvents=[[this.picker,{click:e.proxy(this.click,this)}],[e(window),{resize:e.proxy(this.place,this)}],[e(document),{mousedown:e.proxy(function(e){this.element.is(e.target)||this.element.find(e.target).size()||this.picker.is(e.target)||this.picker.find(e.target).size()||this.hide()},this)}]]},_attachEvents:function(){this._detachEvents(),this._applyEvents(this._events)},_detachEvents:function(){this._unapplyEvents(this._events)},_attachSecondaryEvents:function(){this._detachSecondaryEvents(),this._applyEvents(this._secondaryEvents)},_detachSecondaryEvents:function(){this._unapplyEvents(this._secondaryEvents)},_trigger:function(t,n){var r=n||this.date,i=new Date(r.getTime()+r.getTimezoneOffset()*6e4);this.element.trigger({type:t,date:i,format:e.proxy(function(e){var t=e||this.o.format;return h.formatDate(r,t,this.o.language)},this)})},show:function(e){this.isInline||this.picker.appendTo("body"),this.picker.show(),this.height=this.component?this.component.outerHeight():this.element.outerHeight(),this.place(),this._attachSecondaryEvents(),e&&e.preventDefault(),this._trigger("show")},hide:function(e){if(this.isInline)return;if(!this.picker.is(":visible"))return;this.picker.hide().detach(),this._detachSecondaryEvents(),this.viewMode=this.o.startView,this.showMode(),this.o.forceParse&&(this.isInput&&this.element.val()||this.hasInput&&this.element.find("input").val())&&this.setValue(),this._trigger("hide")},remove:function(){this.hide(),this._detachEvents(),this._detachSecondaryEvents(),this.picker.remove(),delete this.element.data().datepicker,this.isInput||delete this.element.data().date},getDate:function(){var e=this.getUTCDate();return new Date(e.getTime()+e.getTimezoneOffset()*6e4)},getUTCDate:function(){return this.date},setDate:function(e){this.setUTCDate(new Date(e.getTime()-e.getTimezoneOffset()*6e4))},setUTCDate:function(e){this.date=e,this.setValue()},setValue:function(){var e=this.getFormattedDate();this.isInput?this.element.val(e):this.component&&this.element.find("input").val(e)},getFormattedDate:function(e){return e===undefined&&(e=this.o.format),h.formatDate(this.date,e,this.o.language)},setStartDate:function(e){this._process_options({startDate:e}),this.update(),this.updateNavArrows()},setEndDate:function(e){this._process_options({endDate:e}),this.update(),this.updateNavArrows()},setDaysOfWeekDisabled:function(e){this._process_options({daysOfWeekDisabled:e}),this.update(),this.updateNavArrows()},place:function(){if(this.isInline)return;var t=parseInt(this.element.parents().filter(function(){return e(this).css("z-index")!="auto"}).first().css("z-index"))+10,n=this.component?this.component.parent().offset():this.element.offset(),r=this.component?this.component.outerHeight(!0):this.element.outerHeight(!0);this.picker.css({top:n.top+r,left:n.left,zIndex:t})},_allow_update:!0,update:function(){if(!this._allow_update)return;var e,t=!1;arguments&&arguments.length&&(typeof arguments[0]=="string"||arguments[0]instanceof Date)?(e=arguments[0],t=!0):(e=this.isInput?this.element.val():this.element.data("date")||this.element.find("input").val(),delete this.element.data().date),this.date=h.parseDate(e,this.o.format,this.o.language),t&&this.setValue(),this.date<this.o.startDate?this.viewDate=new Date(this.o.startDate):this.date>this.o.endDate?this.viewDate=new Date(this.o.endDate):this.viewDate=new Date(this.date),this.fill()},fillDow:function(){var e=this.o.weekStart,t="<tr>";if(this.o.calendarWeeks){var n='<th class="cw">&nbsp;</th>';t+=n,this.picker.find(".datepicker-days thead tr:first-child").prepend(n)}while(e<this.o.weekStart+7)t+='<th class="dow">'+c[this.o.language].daysMin[e++%7]+"</th>";t+="</tr>",this.picker.find(".datepicker-days thead").append(t)},fillMonths:function(){var e="",t=0;while(t<12)e+='<span class="month">'+c[this.o.language].monthsShort[t++]+"</span>";this.picker.find(".datepicker-months td").html(e)},setRange:function(t){!t||!t.length?delete this.range:this.range=e.map(t,function(e){return e.valueOf()}),this.fill()},getClassNames:function(t){var n=[],r=this.viewDate.getUTCFullYear(),i=this.viewDate.getUTCMonth(),s=this.date.valueOf(),o=new Date;return t.getUTCFullYear()<r||t.getUTCFullYear()==r&&t.getUTCMonth()<i?n.push("old"):(t.getUTCFullYear()>r||t.getUTCFullYear()==r&&t.getUTCMonth()>i)&&n.push("new"),this.o.todayHighlight&&t.getUTCFullYear()==o.getFullYear()&&t.getUTCMonth()==o.getMonth()&&t.getUTCDate()==o.getDate()&&n.push("today"),s&&t.valueOf()==s&&n.push("active"),(t.valueOf()<this.o.startDate||t.valueOf()>this.o.endDate||e.inArray(t.getUTCDay(),this.o.daysOfWeekDisabled)!==-1)&&n.push("disabled"),this.range&&(t>this.range[0]&&t<this.range[this.range.length-1]&&n.push("range"),e.inArray(t.valueOf(),this.range)!=-1&&n.push("selected")),n},fill:function(){var n=new Date(this.viewDate),r=n.getUTCFullYear(),i=n.getUTCMonth(),s=this.o.startDate!==-Infinity?this.o.startDate.getUTCFullYear():-Infinity,o=this.o.startDate!==-Infinity?this.o.startDate.getUTCMonth():-Infinity,u=this.o.endDate!==Infinity?this.o.endDate.getUTCFullYear():Infinity,a=this.o.endDate!==Infinity?this.o.endDate.getUTCMonth():Infinity,f=this.date&&this.date.valueOf(),l;this.picker.find(".datepicker-days thead th.datepicker-switch").text(c[this.o.language].months[i]+" "+r),this.picker.find("tfoot th.today").text(c[this.o.language].today).toggle(this.o.todayBtn!==!1),this.picker.find("tfoot th.clear").text(c[this.o.language].clear).toggle(this.o.clearBtn!==!1),this.updateNavArrows(),this.fillMonths();var p=t(r,i-1,28,0,0,0,0),d=h.getDaysInMonth(p.getUTCFullYear(),p.getUTCMonth());p.setUTCDate(d),p.setUTCDate(d-(p.getUTCDay()-this.o.weekStart+7)%7);var v=new Date(p);v.setUTCDate(v.getUTCDate()+42),v=v.valueOf();var m=[],g;while(p.valueOf()<v){if(p.getUTCDay()==this.o.weekStart){m.push("<tr>");if(this.o.calendarWeeks){var y=new Date(+p+(this.o.weekStart-p.getUTCDay()-7)%7*864e5),b=new Date(+y+(11-y.getUTCDay())%7*864e5),w=new Date(+(w=t(b.getUTCFullYear(),0,1))+(11-w.getUTCDay())%7*864e5),E=(b-w)/864e5/7+1;m.push('<td class="cw">'+E+"</td>")}}g=this.getClassNames(p),g.push("day");var S=this.o.beforeShowDay(p);S===undefined?S={}:typeof S=="boolean"?S={enabled:S}:typeof S=="string"&&(S={classes:S}),S.enabled===!1&&g.push("disabled"),S.classes&&(g=g.concat(S.classes.split(/\s+/))),S.tooltip&&(l=S.tooltip),g=e.unique(g),m.push('<td class="'+g.join(" ")+'"'+(l?' title="'+l+'"':"")+">"+p.getUTCDate()+"</td>"),p.getUTCDay()==this.o.weekEnd&&m.push("</tr>"),p.setUTCDate(p.getUTCDate()+1)}this.picker.find(".datepicker-days tbody").empty().append(m.join(""));var x=this.date&&this.date.getUTCFullYear(),T=this.picker.find(".datepicker-months").find("th:eq(1)").text(r).end().find("span").removeClass("active");x&&x==r&&T.eq(this.date.getUTCMonth()).addClass("active"),(r<s||r>u)&&T.addClass("disabled"),r==s&&T.slice(0,o).addClass("disabled"),r==u&&T.slice(a+1).addClass("disabled"),m="",r=parseInt(r/10,10)*10;var N=this.picker.find(".datepicker-years").find("th:eq(1)").text(r+"-"+(r+9)).end().find("td");r-=1;for(var C=-1;C<11;C++)m+='<span class="year'+(C==-1?" old":C==10?" new":"")+(x==r?" active":"")+(r<s||r>u?" disabled":"")+'">'+r+"</span>",r+=1;N.html(m)},updateNavArrows:function(){if(!this._allow_update)return;var e=new Date(this.viewDate),t=e.getUTCFullYear(),n=e.getUTCMonth();switch(this.viewMode){case 0:this.o.startDate!==-Infinity&&t<=this.o.startDate.getUTCFullYear()&&n<=this.o.startDate.getUTCMonth()?this.picker.find(".prev").css({visibility:"hidden"}):this.picker.find(".prev").css({visibility:"visible"}),this.o.endDate!==Infinity&&t>=this.o.endDate.getUTCFullYear()&&n>=this.o.endDate.getUTCMonth()?this.picker.find(".next").css({visibility:"hidden"}):this.picker.find(".next").css({visibility:"visible"});break;case 1:case 2:this.o.startDate!==-Infinity&&t<=this.o.startDate.getUTCFullYear()?this.picker.find(".prev").css({visibility:"hidden"}):this.picker.find(".prev").css({visibility:"visible"}),this.o.endDate!==Infinity&&t>=this.o.endDate.getUTCFullYear()?this.picker.find(".next").css({visibility:"hidden"}):this.picker.find(".next").css({visibility:"visible"})}},click:function(n){n.preventDefault();var r=e(n.target).closest("span, td, th");if(r.length==1)switch(r[0].nodeName.toLowerCase()){case"th":switch(r[0].className){case"datepicker-switch":this.showMode(1);break;case"prev":case"next":var i=h.modes[this.viewMode].navStep*(r[0].className=="prev"?-1:1);switch(this.viewMode){case 0:this.viewDate=this.moveMonth(this.viewDate,i);break;case 1:case 2:this.viewDate=this.moveYear(this.viewDate,i)}this.fill();break;case"today":var s=new Date;s=t(s.getFullYear(),s.getMonth(),s.getDate(),0,0,0),this.showMode(-2);var o=this.o.todayBtn=="linked"?null:"view";this._setDate(s,o);break;case"clear":var u;this.isInput?u=this.element:this.component&&(u=this.element.find("input")),u&&u.val("").change(),this._trigger("changeDate"),this.update(),this.o.autoclose&&this.hide()}break;case"span":if(!r.is(".disabled")){this.viewDate.setUTCDate(1);if(r.is(".month")){var a=1,f=r.parent().find("span").index(r),l=this.viewDate.getUTCFullYear();this.viewDate.setUTCMonth(f),this._trigger("changeMonth",this.viewDate),this.o.minViewMode===1&&this._setDate(t(l,f,a,0,0,0,0))}else{var l=parseInt(r.text(),10)||0,a=1,f=0;this.viewDate.setUTCFullYear(l),this._trigger("changeYear",this.viewDate),this.o.minViewMode===2&&this._setDate(t(l,f,a,0,0,0,0))}this.showMode(-1),this.fill()}break;case"td":if(r.is(".day")&&!r.is(".disabled")){var a=parseInt(r.text(),10)||1,l=this.viewDate.getUTCFullYear(),f=this.viewDate.getUTCMonth();r.is(".old")?f===0?(f=11,l-=1):f-=1:r.is(".new")&&(f==11?(f=0,l+=1):f+=1),this._setDate(t(l,f,a,0,0,0,0))}}},_setDate:function(e,t){if(!t||t=="date")this.date=new Date(e);if(!t||t=="view")this.viewDate=new Date(e);this.fill(),this.setValue(),this._trigger("changeDate");var n;this.isInput?n=this.element:this.component&&(n=this.element.find("input")),n&&(n.change(),this.o.autoclose&&(!t||t=="date")&&this.hide())},moveMonth:function(e,t){if(!t)return e;var n=new Date(e.valueOf()),r=n.getUTCDate(),i=n.getUTCMonth(),s=Math.abs(t),o,u;t=t>0?1:-1;if(s==1){u=t==-1?function(){return n.getUTCMonth()==i}:function(){return n.getUTCMonth()!=o},o=i+t,n.setUTCMonth(o);if(o<0||o>11)o=(o+12)%12}else{for(var a=0;a<s;a++)n=this.moveMonth(n,t);o=n.getUTCMonth(),n.setUTCDate(r),u=function(){return o!=n.getUTCMonth()}}while(u())n.setUTCDate(--r),n.setUTCMonth(o);return n},moveYear:function(e,t){return this.moveMonth(e,t*12)},dateWithinRange:function(e){return e>=this.o.startDate&&e<=this.o.endDate},keydown:function(e){if(this.picker.is(":not(:visible)")){e.keyCode==27&&this.show();return}var t=!1,n,r,i,s,o;switch(e.keyCode){case 27:this.hide(),e.preventDefault();break;case 37:case 39:if(!this.o.keyboardNavigation)break;n=e.keyCode==37?-1:1,e.ctrlKey?(s=this.moveYear(this.date,n),o=this.moveYear(this.viewDate,n)):e.shiftKey?(s=this.moveMonth(this.date,n),o=this.moveMonth(this.viewDate,n)):(s=new Date(this.date),s.setUTCDate(this.date.getUTCDate()+n),o=new Date(this.viewDate),o.setUTCDate(this.viewDate.getUTCDate()+n)),this.dateWithinRange(s)&&(this.date=s,this.viewDate=o,this.setValue(),this.update(),e.preventDefault(),t=!0);break;case 38:case 40:if(!this.o.keyboardNavigation)break;n=e.keyCode==38?-1:1,e.ctrlKey?(s=this.moveYear(this.date,n),o=this.moveYear(this.viewDate,n)):e.shiftKey?(s=this.moveMonth(this.date,n),o=this.moveMonth(this.viewDate,n)):(s=new Date(this.date),s.setUTCDate(this.date.getUTCDate()+n*7),o=new Date(this.viewDate),o.setUTCDate(this.viewDate.getUTCDate()+n*7)),this.dateWithinRange(s)&&(this.date=s,this.viewDate=o,this.setValue(),this.update(),e.preventDefault(),t=!0);break;case 13:this.hide(),e.preventDefault();break;case 9:this.hide()}if(t){this._trigger("changeDate");var u;this.isInput?u=this.element:this.component&&(u=this.element.find("input")),u&&u.change()}},showMode:function(e){e&&(this.viewMode=Math.max(this.o.minViewMode,Math.min(2,this.viewMode+e))),this.picker.find(">div").hide().filter(".datepicker-"+h.modes[this.viewMode].clsName).css("display","block"),this.updateNavArrows()}};var i=function(t,n){this.element=e(t),this.inputs=e.map(n.inputs,function(e){return e.jquery?e[0]:e}),delete n.inputs,e(this.inputs).datepicker(n).bind("changeDate",e.proxy(this.dateUpdated,this)),this.pickers=e.map(this.inputs,function(t){return e(t).data("datepicker")}),this.updateDates()};i.prototype={updateDates:function(){this.dates=e.map(this.pickers,function(e){return e.date}),this.updateRanges()},updateRanges:function(){var t=e.map(this.dates,function(e){return e.valueOf()});e.each(this.pickers,function(e,n){n.setRange(t)})},dateUpdated:function(t){var n=e(t.target).data("datepicker"),r=n.getUTCDate(),i=e.inArray(t.target,this.inputs),s=this.inputs.length;if(i==-1)return;if(r<this.dates[i])while(i>=0&&r<this.dates[i])this.pickers[i--].setUTCDate(r);else if(r>this.dates[i])while(i<s&&r>this.dates[i])this.pickers[i++].setUTCDate(r);this.updateDates()},remove:function(){e.map(this.pickers,function(e){e.remove()}),delete this.element.data().datepicker}};var u=e.fn.datepicker,a=e.fn.datepicker=function(t){var n=Array.apply(null,arguments);n.shift();var u,a;return this.each(function(){var a=e(this),l=a.data("datepicker"),c=typeof t=="object"&&t;if(!l){var h=s(this,"date"),p=e.extend({},f,h,c),d=o(p.language),v=e.extend({},f,d,h,c);if(a.is(".input-daterange")||v.inputs){var m={inputs:v.inputs||a.find("input").toArray()};a.data("datepicker",l=new i(this,e.extend(v,m)))}else a.data("datepicker",l=new r(this,v))}if(typeof t=="string"&&typeof l[t]=="function"){u=l[t].apply(l,n);if(u!==undefined)return!1}}),u!==undefined?u:this},f=e.fn.datepicker.defaults={autoclose:!1,beforeShowDay:e.noop,calendarWeeks:!1,clearBtn:!1,daysOfWeekDisabled:[],endDate:Infinity,forceParse:!0,format:"mm/dd/yyyy",keyboardNavigation:!0,language:"en",minViewMode:0,rtl:!1,startDate:-Infinity,startView:0,todayBtn:!1,todayHighlight:!1,weekStart:0},l=e.fn.datepicker.locale_opts=["format","rtl","weekStart"];e.fn.datepicker.Constructor=r;var c=e.fn.datepicker.dates={en:{days:["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],daysShort:["Sun","Mon","Tue","Wed","Thu","Fri","Sat","Sun"],daysMin:["Su","Mo","Tu","We","Th","Fr","Sa","Su"],months:["January","February","March","April","May","June","July","August","September","October","November","December"],monthsShort:["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],today:"Today",clear:"Clear"}},h={modes:[{clsName:"days",navFnc:"Month",navStep:1},{clsName:"months",navFnc:"FullYear",navStep:1},{clsName:"years",navFnc:"FullYear",navStep:10}],isLeapYear:function(e){return e%4===0&&e%100!==0||e%400===0},getDaysInMonth:function(e,t){return[31,h.isLeapYear(e)?29:28,31,30,31,30,31,31,30,31,30,31][t]},validParts:/dd?|DD?|mm?|MM?|yy(?:yy)?/g,nonpunctuation:/[^ -\/:-@\[\u3400-\u9fff-`{-~\t\n\r]+/g,parseFormat:function(e){var t=e.replace(this.validParts,"\0").split("\0"),n=e.match(this.validParts);if(!t||!t.length||!n||n.length===0)throw new Error("Invalid date format.");return{separators:t,parts:n}},parseDate:function(n,i,s){if(n instanceof Date)return n;typeof i=="string"&&(i=h.parseFormat(i));if(/^[\-+]\d+[dmwy]([\s,]+[\-+]\d+[dmwy])*$/.test(n)){var o=/([\-+]\d+)([dmwy])/,u=n.match(/([\-+]\d+)([dmwy])/g),a,f;n=new Date;for(var l=0;l<u.length;l++){a=o.exec(u[l]),f=parseInt(a[1]);switch(a[2]){case"d":n.setUTCDate(n.getUTCDate()+f);break;case"m":n=r.prototype.moveMonth.call(r.prototype,n,f);break;case"w":n.setUTCDate(n.getUTCDate()+f*7);break;case"y":n=r.prototype.moveYear.call(r.prototype,n,f)}}return t(n.getUTCFullYear(),n.getUTCMonth(),n.getUTCDate(),0,0,0)}var u=n&&n.match(this.nonpunctuation)||[],n=new Date,p={},d=["yyyy","yy","M","MM","m","mm","d","dd"],v={yyyy:function(e,t){return e.setUTCFullYear(t)},yy:function(e,t){return e.setUTCFullYear(2e3+t)},m:function(e,t){t-=1;while(t<0)t+=12;t%=12,e.setUTCMonth(t);while(e.getUTCMonth()!=t)e.setUTCDate(e.getUTCDate()-1);return e},d:function(e,t){return e.setUTCDate(t)}},m,g,a;v.M=v.MM=v.mm=v.m,v.dd=v.d,n=t(n.getFullYear(),n.getMonth(),n.getDate(),0,0,0);var y=i.parts.slice();u.length!=y.length&&(y=e(y).filter(function(t,n){return e.inArray(n,d)!==-1}).toArray());if(u.length==y.length){for(var l=0,b=y.length;l<b;l++){m=parseInt(u[l],10),a=y[l];if(isNaN(m))switch(a){case"MM":g=e(c[s].months).filter(function(){var e=this.slice(0,u[l].length),t=u[l].slice(0,e.length);return e==t}),m=e.inArray(g[0],c[s].months)+1;break;case"M":g=e(c[s].monthsShort).filter(function(){var e=this.slice(0,u[l].length),t=u[l].slice(0,e.length);return e==t}),m=e.inArray(g[0],c[s].monthsShort)+1}p[a]=m}for(var l=0,w;l<d.length;l++)w=d[l],w in p&&!isNaN(p[w])&&v[w](n,p[w])}return n},formatDate:function(t,n,r){typeof n=="string"&&(n=h.parseFormat(n));var i={d:t.getUTCDate(),D:c[r].daysShort[t.getUTCDay()],DD:c[r].days[t.getUTCDay()],m:t.getUTCMonth()+1,M:c[r].monthsShort[t.getUTCMonth()],MM:c[r].months[t.getUTCMonth()],yy:t.getUTCFullYear().toString().substring(2),yyyy:t.getUTCFullYear()};i.dd=(i.d<10?"0":"")+i.d,i.mm=(i.m<10?"0":"")+i.m;var t=[],s=e.extend([],n.separators);for(var o=0,u=n.parts.length;o<=u;o++)s.length&&t.push(s.shift()),t.push(i[n.parts[o]]);return t.join("")},headTemplate:'<thead><tr><th class="prev"><i class="icon-arrow-left"/></th><th colspan="5" class="datepicker-switch"></th><th class="next"><i class="icon-arrow-right"/></th></tr></thead>',contTemplate:'<tbody><tr><td colspan="7"></td></tr></tbody>',footTemplate:'<tfoot><tr><th colspan="7" class="today"></th></tr><tr><th colspan="7" class="clear"></th></tr></tfoot>'};h.template='<div class="datepicker"><div class="datepicker-days"><table class=" table-condensed">'+h.headTemplate+"<tbody></tbody>"+h.footTemplate+"</table>"+"</div>"+'<div class="datepicker-months">'+'<table class="table-condensed">'+h.headTemplate+h.contTemplate+h.footTemplate+"</table>"+"</div>"+'<div class="datepicker-years">'+'<table class="table-condensed">'+h.headTemplate+h.contTemplate+h.footTemplate+"</table>"+"</div>"+"</div>",e.fn.datepicker.DPGlobal=h,e.fn.datepicker.noConflict=function(){return e.fn.datepicker=u,this},e(document).on("focus.datepicker.data-api click.datepicker.data-api",'[data-provide="datepicker"]',function(t){var n=e(this);if(n.data("datepicker"))return;t.preventDefault(),a.call(n,"show")}),e(function(){a.call(e('[data-provide="datepicker-inline"]'))})}(window.jQuery),function(e){"use strict";e.fn.bdatepicker=e.fn.datepicker.noConflict(),e.fn.datepicker||(e.fn.datepicker=e.fn.bdatepicker);var t=function(e){this.init("date",e,t.defaults),this.initPicker(e,t.defaults)};e.fn.editableutils.inherit(t,e.fn.editabletypes.abstractinput),e.extend(t.prototype,{initPicker:function(t,n){this.options.viewformat||(this.options.viewformat=this.options.format),this.options.datepicker=e.extend({},n.datepicker,t.datepicker,{format:this.options.viewformat}),this.options.datepicker.language=this.options.datepicker.language||"en",this.dpg=e.fn.bdatepicker.DPGlobal,this.parsedFormat=this.dpg.parseFormat(this.options.format),this.parsedViewFormat=this.dpg.parseFormat(this.options.viewformat)},render:function(){this.$input.bdatepicker(this.options.datepicker),this.options.clear&&(this.$clear=e('<a href="#"></a>').html(this.options.clear).click(e.proxy(function(e){e.preventDefault(),e.stopPropagation(),this.clear()},this)),this.$tpl.parent().append(e('<div class="editable-clear">').append(this.$clear)))},value2html:function(e,n){var r=e?this.dpg.formatDate(e,this.parsedViewFormat,this.options.datepicker.language):"";t.superclass.value2html(r,n)},html2value:function(e){return this.parseDate(e,this.parsedViewFormat)},value2str:function(e){return e?this.dpg.formatDate(e,this.parsedFormat,this.options.datepicker.language):""},str2value:function(e){return this.parseDate(e,this.parsedFormat)},value2submit:function(e){return this.value2str(e)},value2input:function(e){this.$input.bdatepicker("update",e)},input2value:function(){return this.$input.data("datepicker").date},activate:function(){},clear:function(){this.$input.data("datepicker").date=null,this.$input.find(".active").removeClass("active"),this.options.showbuttons||this.$input.closest("form").submit()},autosubmit:function(){this.$input.on("mouseup",".day",function(t){if(e(t.currentTarget).is(".old")||e(t.currentTarget).is(".new"))return;var n=e(this).closest("form");setTimeout(function(){n.submit()},200)})},parseDate:function(e,t){var n=null,r;return e&&(n=this.dpg.parseDate(e,t,this.options.datepicker.language),typeof e=="string"&&(r=this.dpg.formatDate(n,t,this.options.datepicker.language),e!==r&&(n=null))),n}}),t.defaults=e.extend({},e.fn.editabletypes.abstractinput.defaults,{tpl:'<div class="editable-date well"></div>',inputclass:null,format:"yyyy-mm-dd",viewformat:null,datepicker:{weekStart:0,startView:0,minViewMode:0,autoclose:!1},clear:"&times; clear"}),e.fn.editabletypes.date=t}(window.jQuery),function(e){"use strict";var t=function(e){this.init("datefield",e,t.defaults),this.initPicker(e,t.defaults)};e.fn.editableutils.inherit(t,e.fn.editabletypes.date),e.extend(t.prototype,{render:function(){this.$input=this.$tpl.find("input"),this.setClass(),this.setAttr("placeholder"),this.$tpl.bdatepicker(this.options.datepicker),this.$input.off("focus keydown"),this.$input.keyup(e.proxy(function(){this.$tpl.removeData("date"),this.$tpl.bdatepicker("update")},this))},value2input:function(e){this.$input.val(e?this.dpg.formatDate(e,this.parsedViewFormat,this.options.datepicker.language):""),this.$tpl.bdatepicker("update")},input2value:function(){return this.html2value(this.$input.val())},activate:function(){e.fn.editabletypes.text.prototype.activate.call(this)},autosubmit:function(){}}),t.defaults=e.extend({},e.fn.editabletypes.date.defaults,{tpl:'<div class="input-append date"><input type="text"/><span class="add-on"><i class="icon-th"></i></span></div>',inputclass:"input-small",datepicker:{weekStart:0,startView:0,minViewMode:0,autoclose:!0}}),e.fn.editabletypes.datefield=t}(window.jQuery),function(e){"use strict";var t=function(e){this.init("datetime",e,t.defaults),this.initPicker(e,t.defaults)};e.fn.editableutils.inherit(t,e.fn.editabletypes.abstractinput),e.extend(t.prototype,{initPicker:function(t,n){this.options.viewformat||(this.options.viewformat=this.options.format),this.options.datetimepicker=e.extend({},n.datetimepicker,t.datetimepicker,{format:this.options.viewformat}),this.options.datetimepicker.language=this.options.datetimepicker.language||"en",this.dpg=e.fn.datetimepicker.DPGlobal,this.parsedFormat=this.dpg.parseFormat(this.options.format,this.options.formatType),this.parsedViewFormat=this.dpg.parseFormat(this.options.viewformat,this.options.formatType)},render:function(){this.$input.datetimepicker(this.options.datetimepicker),this.$input.on("changeMode",function(t){var n=e(this).closest("form").parent();setTimeout(function(){n.triggerHandler("resize")},0)}),this.options.clear&&(this.$clear=e('<a href="#"></a>').html(this.options.clear).click(e.proxy(function(e){e.preventDefault(),e.stopPropagation(),this.clear()},this)),this.$tpl.parent().append(e('<div class="editable-clear">').append(this.$clear)))},value2html:function(e,n){var r=e?this.dpg.formatDate(this.toUTC(e),this.parsedViewFormat,this.options.datetimepicker.language,this.options.formatType):"";if(!n)return r;t.superclass.value2html(r,n)},html2value:function(e){var t=this.parseDate(e,this.parsedViewFormat);return t?this.fromUTC(t):null},value2str:function(e){return e?this.dpg.formatDate(this.toUTC(e),this.parsedFormat,this.options.datetimepicker.language,this.options.formatType):""},str2value:function(e){var t=this.parseDate(e,this.parsedFormat);return t?this.fromUTC(t):null},value2submit:function(e){return this.value2str(e)},value2input:function(e){e&&this.$input.data("datetimepicker").setDate(e)},input2value:function(){var e=this.$input.data("datetimepicker");return e.date?e.getDate():null},activate:function(){},clear:function(){this.$input.data("datetimepicker").date=null,this.$input.find(".active").removeClass("active"),this.options.showbuttons||this.$input.closest("form").submit()},autosubmit:function(){this.$input.on("mouseup",".minute",function(t){var n=e(this).closest("form");setTimeout(function(){n.submit()},200)})},toUTC:function(e){return e?new Date(e.valueOf()-e.getTimezoneOffset()*6e4):e},fromUTC:function(e){return e?new Date(e.valueOf()+e.getTimezoneOffset()*6e4):e},parseDate:function(e,t){var n=null,r;return e&&(n=this.dpg.parseDate(e,t,this.options.datetimepicker.language,this.options.formatType),typeof e=="string"&&(r=this.dpg.formatDate(n,t,this.options.datetimepicker.language,this.options.formatType),e!==r&&(n=null))),n}}),t.defaults=e.extend({},e.fn.editabletypes.abstractinput.defaults,{tpl:'<div class="editable-date well"></div>',inputclass:null,format:"yyyy-mm-dd hh:ii",formatType:"standard",viewformat:null,datetimepicker:{todayHighlight:!1,autoclose:!1},clear:"&times; clear"}),e.fn.editabletypes.datetime=t}(window.jQuery),function(e){"use strict";var t=function(e){this.init("datetimefield",e,t.defaults),this.initPicker(e,t.defaults)};e.fn.editableutils.inherit(t,e.fn.editabletypes.datetime),e.extend(t.prototype,{render:function(){this.$input=this.$tpl.find("input"),this.setClass(),this.setAttr("placeholder"),this.$tpl.datetimepicker(this.options.datetimepicker),this.$input.off("focus keydown"),this.$input.keyup(e.proxy(function(){this.$tpl.removeData("date"),this.$tpl.datetimepicker("update")},this))},value2input:function(e){this.$input.val(this.value2html(e)),this.$tpl.datetimepicker("update")},input2value:function(){return this.html2value(this.$input.val())},activate:function(){e.fn.editabletypes.text.prototype.activate.call(this)},autosubmit:function(){}}),t.defaults=e.extend({},e.fn.editabletypes.datetime.defaults,{tpl:'<div class="input-append date"><input type="text"/><span class="add-on"><i class="icon-th"></i></span></div>',inputclass:"input-medium",datetimepicker:{todayHighlight:!1,autoclose:!0}}),e.fn.editabletypes.datetimefield=t}(window.jQuery),function(e){"use strict";var t=function(n){this.init("typeahead",n,t.defaults),this.options.typeahead=e.extend({},t.defaults.typeahead,{matcher:this.matcher,sorter:this.sorter,highlighter:this.highlighter,updater:this.updater},n.typeahead)};e.fn.editableutils.inherit(t,e.fn.editabletypes.list),e.extend(t.prototype,{renderList:function(){this.$input=this.$tpl.is("input")?this.$tpl:this.$tpl.find('input[type="text"]'),this.options.typeahead.source=this.sourceData,this.$input.typeahead(this.options.typeahead);var t=this.$input.data("typeahead");t.render=e.proxy(this.typeaheadRender,t),t.select=e.proxy(this.typeaheadSelect,t),t.move=e.proxy(this.typeaheadMove,t),this.renderClear(),this.setClass(),this.setAttr("placeholder")},value2htmlFinal:function(t,n){if(this.getIsObjects()){var r=e.fn.editableutils.itemsByValue(t,this.sourceData);e(n).text(r.length?r[0].text:"")}else e(n).text(t)},html2value:function(e){return e?e:null},value2input:function(t){if(this.getIsObjects()){var n=e.fn.editableutils.itemsByValue(t,this.sourceData);this.$input.data("value",t).val(n.length?n[0].text:"")}else this.$input.val(t)},input2value:function(){if(this.getIsObjects()){var t=this.$input.data("value"),n=e.fn.editableutils.itemsByValue(t,this.sourceData);return n.length&&n[0].text.toLowerCase()===this.$input.val().toLowerCase()?t:null}return this.$input.val()},getIsObjects:function(){if(this.isObjects===undefined){this.isObjects=!1;for(var e=0;e<this.sourceData.length;e++)if(this.sourceData[e].value!==this.sourceData[e].text){this.isObjects=!0;break}}return this.isObjects},activate:e.fn.editabletypes.text.prototype.activate,renderClear:e.fn.editabletypes.text.prototype.renderClear,postrender:e.fn.editabletypes.text.prototype.postrender,toggleClear:e.fn.editabletypes.text.prototype.toggleClear,clear:function(){e.fn.editabletypes.text.prototype.clear.call(this),this.$input.data("value","")},matcher:function(t){return e.fn.typeahead.Constructor.prototype.matcher.call(this,t.text)},sorter:function(e){var t=[],n=[],r=[],i,s;while(i=e.shift())s=i.text,s.toLowerCase().indexOf(this.query.toLowerCase())?~s.indexOf(this.query)?n.push(i):r.push(i):t.push(i);return t.concat(n,r)},highlighter:function(t){return e.fn.typeahead.Constructor.prototype.highlighter.call(this,t.text)},updater:function(e){return this.$element.data("value",e.value),e.text},typeaheadRender:function(t){var n=this;return t=e(t).map(function(t,r){return t=e(n.options.item).data("item",r),t.find("a").html(n.highlighter(r)),t[0]}),this.options.autoSelect&&t.first().addClass("active"),this.$menu.html(t),this},typeaheadSelect:function(){var e=this.$menu.find(".active").data("item");return(this.options.autoSelect||e)&&this.$element.val(this.updater(e)).change(),this.hide()},typeaheadMove:function(e){if(!this.shown)return;switch(e.keyCode){case 9:case 13:case 27:if(!this.$menu.find(".active").length)return;e.preventDefault();break;case 38:e.preventDefault(),this.prev();break;case 40:e.preventDefault(),this.next()}e.stopPropagation()}}),t.defaults=e.extend({},e.fn.editabletypes.list.defaults,{tpl:'<input type="text">',typeahead:null,clear:!0}),e.fn.editabletypes.typeahead=t}(window.jQuery);