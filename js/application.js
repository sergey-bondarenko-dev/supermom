/*!
 * jQuery JavaScript Library v1.9.1
 * http://jquery.com/
 *
 * Includes Sizzle.js
 * http://sizzlejs.com/
 *
 * Copyright 2005, 2012 jQuery Foundation, Inc. and other contributors
 * Released under the MIT license
 * http://jquery.org/license
 *
 * Date: 2013-2-4
 */

! function ($, undefined) {
    "use strict";
    $.rails !== undefined && $.error("jquery-ujs has already been loaded!");
    var rails, $document = $(document);
    $.rails = rails = {
        linkClickSelector: "a[data-confirm], a[data-method], a[data-remote]:not([disabled]), a[data-disable-with], a[data-disable]",
        buttonClickSelector: "button[data-remote]:not([form]):not(form button), button[data-confirm]:not([form]):not(form button)",
        inputChangeSelector: "select[data-remote], input[data-remote], textarea[data-remote]",
        formSubmitSelector: "form",
        formInputClickSelector: "form input[type=submit], form input[type=image], form button[type=submit], form button:not([type]), input[type=submit][form], input[type=image][form], button[type=submit][form], button[form]:not([type])",
        disableSelector: "input[data-disable-with]:enabled, button[data-disable-with]:enabled, textarea[data-disable-with]:enabled, input[data-disable]:enabled, button[data-disable]:enabled, textarea[data-disable]:enabled",
        enableSelector: "input[data-disable-with]:disabled, button[data-disable-with]:disabled, textarea[data-disable-with]:disabled, input[data-disable]:disabled, button[data-disable]:disabled, textarea[data-disable]:disabled",
        requiredInputSelector: "input[name][required]:not([disabled]), textarea[name][required]:not([disabled])",
        fileInputSelector: "input[type=file]:not([disabled])",
        linkDisableSelector: "a[data-disable-with], a[data-disable]",
        buttonDisableSelector: "button[data-remote][data-disable-with], button[data-remote][data-disable]",
        csrfToken: function () { return $("meta[name=csrf-token]").attr("content") },
        csrfParam: function () { return $("meta[name=csrf-param]").attr("content") },
        CSRFProtection: function (xhr) {
            var token = rails.csrfToken();
            token && xhr.setRequestHeader("X-CSRF-Token", token)
        },
        refreshCSRFTokens: function () { $('form input[name="' + rails.csrfParam() + '"]').val(rails.csrfToken()) },
        fire: function (obj, name, data) { var event = $.Event(name); return obj.trigger(event, data), event.result !== !1 },
        confirm: function (message) { return confirm(message) },
        ajax: function (options) { return $.ajax(options) },
        href: function (element) { return element[0].href },
        isRemote: function (element) { return element.data("remote") !== undefined && element.data("remote") !== !1 },
        handleRemote: function (element) {
            var method, url, data, withCredentials, dataType, options;
            if (rails.fire(element, "ajax:before")) {
                if (withCredentials = element.data("with-credentials") || null, dataType = element.data("type") || $.ajaxSettings && $.ajaxSettings.dataType, element.is("form")) {
                    method = element.data("ujs:submit-button-formmethod") || element.attr("method"), url = element.data("ujs:submit-button-formaction") || element.attr("action"), data = $(element[0]).serializeArray();
                    var button = element.data("ujs:submit-button");
                    button && (data.push(button), element.data("ujs:submit-button", null)), element.data("ujs:submit-button-formmethod", null), element.data("ujs:submit-button-formaction", null)
                } else element.is(rails.inputChangeSelector) ? (method = element.data("method"), url = element.data("url"), data = element.serialize(), element.data("params") && (data = data + "&" + element.data("params"))) : element.is(rails.buttonClickSelector) ? (method = element.data("method") || "get", url = element.data("url"), data = element.serialize(), element.data("params") && (data = data + "&" + element.data("params"))) : (method = element.data("method"), url = rails.href(element), data = element.data("params") || null);
                return options = { type: method || "GET", data: data, dataType: dataType, beforeSend: function (xhr, settings) { return settings.dataType === undefined && xhr.setRequestHeader("accept", "*/*;q=0.5, " + settings.accepts.script), rails.fire(element, "ajax:beforeSend", [xhr, settings]) ? void element.trigger("ajax:send", xhr) : !1 }, success: function (data, status, xhr) { element.trigger("ajax:success", [data, status, xhr]) }, complete: function (xhr, status) { element.trigger("ajax:complete", [xhr, status]) }, error: function (xhr, status, error) { element.trigger("ajax:error", [xhr, status, error]) }, crossDomain: rails.isCrossDomain(url) }, withCredentials && (options.xhrFields = { withCredentials: withCredentials }), url && (options.url = url), rails.ajax(options)
            }
            return !1
        },
        isCrossDomain: function (url) {
            var originAnchor = document.createElement("a");
            originAnchor.href = location.href;
            var urlAnchor = document.createElement("a");
            try { return urlAnchor.href = url, urlAnchor.href = urlAnchor.href, !((!urlAnchor.protocol || ":" === urlAnchor.protocol) && !urlAnchor.host || originAnchor.protocol + "//" + originAnchor.host == urlAnchor.protocol + "//" + urlAnchor.host) } catch (e) { return !0 }
        },
        handleMethod: function (link) {
            var href = rails.href(link),
                method = link.data("method"),
                target = link.attr("target"),
                csrfToken = rails.csrfToken(),
                csrfParam = rails.csrfParam(),
                form = $('<form method="post" action="' + href + '"></form>'),
                metadataInput = '<input name="_method" value="' + method + '" type="hidden" />';
            csrfParam === undefined || csrfToken === undefined || rails.isCrossDomain(href) || (metadataInput += '<input name="' + csrfParam + '" value="' + csrfToken + '" type="hidden" />'), target && form.attr("target", target), form.hide().append(metadataInput).appendTo("body"), form.submit()
        },
        formElements: function (form, selector) { return form.is("form") ? $(form[0].elements).filter(selector) : form.find(selector) },
        disableFormElements: function (form) { rails.formElements(form, rails.disableSelector).each(function () { rails.disableFormElement($(this)) }) },
        disableFormElement: function (element) {
            var method, replacement;
            method = element.is("button") ? "html" : "val", replacement = element.data("disable-with"), replacement !== undefined && (element.data("ujs:enable-with", element[method]()), element[method](replacement)), element.prop("disabled", !0), element.data("ujs:disabled", !0)
        },
        enableFormElements: function (form) { rails.formElements(form, rails.enableSelector).each(function () { rails.enableFormElement($(this)) }) },
        enableFormElement: function (element) {
            var method = element.is("button") ? "html" : "val";
            element.data("ujs:enable-with") !== undefined && (element[method](element.data("ujs:enable-with")), element.removeData("ujs:enable-with")), element.prop("disabled", !1), element.removeData("ujs:disabled")
        },
        allowAction: function (element) {
            var callback, message = element.data("confirm"),
                answer = !1;
            if (!message) return !0;
            if (rails.fire(element, "confirm")) {
                try { answer = rails.confirm(message) } catch (e) {
                    (console.error || console.log).call(console, e.stack || e)
                }
                callback = rails.fire(element, "confirm:complete", [answer])
            }
            return answer && callback
        },
        blankInputs: function (form, specifiedSelector, nonBlank) {
            var input, valueToCheck, radiosForNameWithNoneSelected, radioName, foundInputs = $(),
                selector = specifiedSelector || "input,textarea",
                requiredInputs = form.find(selector),
                checkedRadioButtonNames = {};
            return requiredInputs.each(function () { input = $(this), input.is("input[type=radio]") ? (radioName = input.attr("name"), checkedRadioButtonNames[radioName] || (0 === form.find('input[type=radio]:checked[name="' + radioName + '"]').length && (radiosForNameWithNoneSelected = form.find('input[type=radio][name="' + radioName + '"]'), foundInputs = foundInputs.add(radiosForNameWithNoneSelected)), checkedRadioButtonNames[radioName] = radioName)) : (valueToCheck = input.is("input[type=checkbox],input[type=radio]") ? input.is(":checked") : !!input.val(), valueToCheck === nonBlank && (foundInputs = foundInputs.add(input))) }), foundInputs.length ? foundInputs : !1
        },
        nonBlankInputs: function (form, specifiedSelector) { return rails.blankInputs(form, specifiedSelector, !0) },
        stopEverything: function (e) { return $(e.target).trigger("ujs:everythingStopped"), e.stopImmediatePropagation(), !1 },
        disableElement: function (element) {
            var replacement = element.data("disable-with");
            replacement !== undefined && (element.data("ujs:enable-with", element.html()), element.html(replacement)), element.bind("click.railsDisable", function (e) { return rails.stopEverything(e) }), element.data("ujs:disabled", !0)
        },
        enableElement: function (element) { element.data("ujs:enable-with") !== undefined && (element.html(element.data("ujs:enable-with")), element.removeData("ujs:enable-with")), element.unbind("click.railsDisable"), element.removeData("ujs:disabled") }
    }, rails.fire($document, "rails:attachBindings") && ($.ajaxPrefilter(function (options, originalOptions, xhr) { options.crossDomain || rails.CSRFProtection(xhr) }), $(window).on("pageshow.rails", function () {
        $($.rails.enableSelector).each(function () {
            var element = $(this);
            element.data("ujs:disabled") && $.rails.enableFormElement(element)
        }), $($.rails.linkDisableSelector).each(function () {
            var element = $(this);
            element.data("ujs:disabled") && $.rails.enableElement(element)
        })
    }), $document.delegate(rails.linkDisableSelector, "ajax:complete", function () { rails.enableElement($(this)) }), $document.delegate(rails.buttonDisableSelector, "ajax:complete", function () { rails.enableFormElement($(this)) }), $document.delegate(rails.linkClickSelector, "click.rails", function (e) {
        var link = $(this),
            method = link.data("method"),
            data = link.data("params"),
            metaClick = e.metaKey || e.ctrlKey;
        if (!rails.allowAction(link)) return rails.stopEverything(e);
        if (!metaClick && link.is(rails.linkDisableSelector) && rails.disableElement(link), rails.isRemote(link)) { if (metaClick && (!method || "GET" === method) && !data) return !0; var handleRemote = rails.handleRemote(link); return handleRemote === !1 ? rails.enableElement(link) : handleRemote.fail(function () { rails.enableElement(link) }), !1 }
        return method ? (rails.handleMethod(link), !1) : void 0
    }), $document.delegate(rails.buttonClickSelector, "click.rails", function (e) {
        var button = $(this);
        if (!rails.allowAction(button) || !rails.isRemote(button)) return rails.stopEverything(e);
        button.is(rails.buttonDisableSelector) && rails.disableFormElement(button);
        var handleRemote = rails.handleRemote(button);
        return handleRemote === !1 ? rails.enableFormElement(button) : handleRemote.fail(function () { rails.enableFormElement(button) }), !1
    }), $document.delegate(rails.inputChangeSelector, "change.rails", function (e) { var link = $(this); return rails.allowAction(link) && rails.isRemote(link) ? (rails.handleRemote(link), !1) : rails.stopEverything(e) }), $document.delegate(rails.formSubmitSelector, "submit.rails", function (e) {
        var blankRequiredInputs, nonBlankFileInputs, form = $(this),
            remote = rails.isRemote(form);
        if (!rails.allowAction(form)) return rails.stopEverything(e);
        if (form.attr("novalidate") === undefined)
            if (form.data("ujs:formnovalidate-button") === undefined) { if (blankRequiredInputs = rails.blankInputs(form, rails.requiredInputSelector, !1), blankRequiredInputs && rails.fire(form, "ajax:aborted:required", [blankRequiredInputs])) return rails.stopEverything(e) } else form.data("ujs:formnovalidate-button", undefined);
        if (remote) { if (nonBlankFileInputs = rails.nonBlankInputs(form, rails.fileInputSelector)) { setTimeout(function () { rails.disableFormElements(form) }, 13); var aborted = rails.fire(form, "ajax:aborted:file", [nonBlankFileInputs]); return aborted || setTimeout(function () { rails.enableFormElements(form) }, 13), aborted } return rails.handleRemote(form), !1 }
        setTimeout(function () { rails.disableFormElements(form) }, 13)
    }), $document.delegate(rails.formInputClickSelector, "click.rails", function (event) {
        var button = $(this);
        if (!rails.allowAction(button)) return rails.stopEverything(event);
        var name = button.attr("name"),
            data = name ? { name: name, value: button.val() } : null,
            form = button.closest("form");
        0 === form.length && (form = $("#" + button.attr("form"))), form.data("ujs:submit-button", data), form.data("ujs:formnovalidate-button", button.attr("formnovalidate")), form.data("ujs:submit-button-formaction", button.attr("formaction")), form.data("ujs:submit-button-formmethod", button.attr("formmethod"))
    }), $document.delegate(rails.formSubmitSelector, "ajax:send.rails", function (event) { this === event.target && rails.disableFormElements($(this)) }), $document.delegate(rails.formSubmitSelector, "ajax:complete.rails", function (event) { this === event.target && rails.enableFormElements($(this)) }), $(function () { rails.refreshCSRFTokens() }))
}(jQuery),



    /* ========================================================================
     * Bootstrap: tab.js v3.3.6
     * http://getbootstrap.com/javascript/#tabs
     * ========================================================================
     * Copyright 2011-2015 Twitter, Inc.
     * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
     * ======================================================================== */
    + function ($) {
        "use strict";

        function Plugin(option) {
            return this.each(function () {
                var $this = $(this),
                    data = $this.data("bs.tab");
                data || $this.data("bs.tab", data = new Tab(this)), "string" == typeof option && data[option]()
            })
        }
        var Tab = function (element) { this.element = $(element) };
        Tab.VERSION = "3.3.6", Tab.TRANSITION_DURATION = 150, Tab.prototype.show = function () {
            var $this = this.element,
                $ul = $this.closest("ul:not(.dropdown-menu)"),
                selector = $this.data("target");
            if (selector || (selector = $this.attr("href"), selector = selector && selector.replace(/.*(?=#[^\s]*$)/, "")), !$this.parent("li").hasClass("active")) {
                var $previous = $ul.find(".active:last a"),
                    hideEvent = $.Event("hide.bs.tab", { relatedTarget: $this[0] }),
                    showEvent = $.Event("show.bs.tab", { relatedTarget: $previous[0] });
                if ($previous.trigger(hideEvent), $this.trigger(showEvent), !showEvent.isDefaultPrevented() && !hideEvent.isDefaultPrevented()) {
                    var $target = $(selector);
                    this.activate($this.closest("li"), $ul), this.activate($target, $target.parent(), function () { $previous.trigger({ type: "hidden.bs.tab", relatedTarget: $this[0] }), $this.trigger({ type: "shown.bs.tab", relatedTarget: $previous[0] }) })
                }
            }
        }, Tab.prototype.activate = function (element, container, callback) {
            function next() { $active.removeClass("active").find("> .dropdown-menu > .active").removeClass("active").end().find('[data-toggle="tab"]').attr("aria-expanded", !1), element.addClass("active").find('[data-toggle="tab"]').attr("aria-expanded", !0), transition ? (element[0].offsetWidth, element.addClass("in")) : element.removeClass("fade"), element.parent(".dropdown-menu").length && element.closest("li.dropdown").addClass("active").end().find('[data-toggle="tab"]').attr("aria-expanded", !0), callback && callback() }
            var $active = container.find("> .active"),
                transition = callback && $.support.transition && ($active.length && $active.hasClass("fade") || !!container.find("> .fade").length);
            $active.length && transition ? $active.one("bsTransitionEnd", next).emulateTransitionEnd(Tab.TRANSITION_DURATION) : next(), $active.removeClass("in")
        };
        var old = $.fn.tab;
        $.fn.tab = Plugin, $.fn.tab.Constructor = Tab, $.fn.tab.noConflict = function () { return $.fn.tab = old, this };
        var clickHandler = function (e) { e.preventDefault(), Plugin.call($(this), "show") };
        $(document).on("click.bs.tab.data-api", '[data-toggle="tab"]', clickHandler).on("click.bs.tab.data-api", '[data-toggle="pill"]', clickHandler)
    }(jQuery),
    function (factory) { "use strict"; "function" == typeof define && define.amd ? define(["./blueimp-helper"], factory) : (window.blueimp = window.blueimp || {}, window.blueimp.Gallery = factory(window.blueimp.helper || window.jQuery)) }(function ($) {
        "use strict";

        function Gallery(list, options) { return void 0 === document.body.style.maxHeight ? null : this && this.options === Gallery.prototype.options ? list && list.length ? (this.list = list, this.num = list.length, this.initOptions(options), void this.initialize()) : void this.console.log("blueimp Gallery: No or empty list provided as first argument.", list) : new Gallery(list, options) }
        return $.extend(Gallery.prototype, {
            options: { container: "#blueimp-gallery", slidesContainer: "div", titleElement: "h3", displayClass: "blueimp-gallery-display", controlsClass: "blueimp-gallery-controls", singleClass: "blueimp-gallery-single", leftEdgeClass: "blueimp-gallery-left", rightEdgeClass: "blueimp-gallery-right", playingClass: "blueimp-gallery-playing", slideClass: "slide", slideLoadingClass: "slide-loading", slideErrorClass: "slide-error", slideContentClass: "slide-content", toggleClass: "toggle", prevClass: "prev", nextClass: "next", closeClass: "close", playPauseClass: "play-pause", typeProperty: "type", titleProperty: "title", urlProperty: "href", srcsetProperty: "urlset", displayTransition: !0, clearSlides: !0, stretchImages: !1, toggleControlsOnReturn: !0, toggleControlsOnSlideClick: !0, toggleSlideshowOnSpace: !0, enableKeyboardNavigation: !0, closeOnEscape: !0, closeOnSlideClick: !0, closeOnSwipeUpOrDown: !0, emulateTouchEvents: !0, stopTouchEventsPropagation: !1, hidePageScrollbars: !0, disableScroll: !0, carousel: !1, continuous: !0, unloadElements: !0, startSlideshow: !1, slideshowInterval: 5e3, index: 0, preloadRange: 2, transitionSpeed: 400, slideshowTransitionSpeed: void 0, event: void 0, onopen: void 0, onopened: void 0, onslide: void 0, onslideend: void 0, onslidecomplete: void 0, onclose: void 0, onclosed: void 0 },
            carouselOptions: { hidePageScrollbars: !1, toggleControlsOnReturn: !1, toggleSlideshowOnSpace: !1, enableKeyboardNavigation: !1, closeOnEscape: !1, closeOnSlideClick: !1, closeOnSwipeUpOrDown: !1, disableScroll: !1, startSlideshow: !0 },
            console: window.console && "function" == typeof window.console.log ? window.console : { log: function () { } },
            support: function (element) {
                function elementTests() {
                    var prop, translateZ, transition = support.transition;
                    document.body.appendChild(element), transition && (prop = transition.name.slice(0, -9) + "ransform", void 0 !== element.style[prop] && (element.style[prop] = "translateZ(0)", translateZ = window.getComputedStyle(element).getPropertyValue(transition.prefix + "transform"), support.transform = { prefix: transition.prefix, name: prop, translate: !0, translateZ: !!translateZ && "none" !== translateZ })), void 0 !== element.style.backgroundSize && (support.backgroundSize = {}, element.style.backgroundSize = "contain", support.backgroundSize.contain = "contain" === window.getComputedStyle(element).getPropertyValue("background-size"), element.style.backgroundSize = "cover", support.backgroundSize.cover = "cover" === window.getComputedStyle(element).getPropertyValue("background-size")), document.body.removeChild(element)
                }
                var prop, support = { touch: void 0 !== window.ontouchstart || window.DocumentTouch && document instanceof DocumentTouch },
                    transitions = { webkitTransition: { end: "webkitTransitionEnd", prefix: "-webkit-" }, MozTransition: { end: "transitionend", prefix: "-moz-" }, OTransition: { end: "otransitionend", prefix: "-o-" }, transition: { end: "transitionend", prefix: "" } };
                for (prop in transitions)
                    if (transitions.hasOwnProperty(prop) && void 0 !== element.style[prop]) { support.transition = transitions[prop], support.transition.name = prop; break }
                return document.body ? elementTests() : $(document).on("DOMContentLoaded", elementTests), support
            }(document.createElement("div")),
            requestAnimationFrame: window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame,
            initialize: function () { return this.initStartIndex(), this.initWidget() === !1 ? !1 : (this.initEventListeners(), this.onslide(this.index), this.ontransitionend(), void (this.options.startSlideshow && this.play())) },
            slide: function (to, speed) {
                window.clearTimeout(this.timeout);
                var direction, naturalDirection, diff, index = this.index;
                if (index !== to && 1 !== this.num) {
                    if (speed || (speed = this.options.transitionSpeed), this.support.transform) {
                        for (this.options.continuous || (to = this.circle(to)), direction = Math.abs(index - to) / (index - to), this.options.continuous && (naturalDirection = direction, direction = -this.positions[this.circle(to)] / this.slideWidth, direction !== naturalDirection && (to = -direction * this.num + to)), diff = Math.abs(index - to) - 1; diff;) diff -= 1, this.move(this.circle((to > index ? to : index) - diff - 1), this.slideWidth * direction, 0);
                        to = this.circle(to), this.move(index, this.slideWidth * direction, speed), this.move(to, 0, speed), this.options.continuous && this.move(this.circle(to - direction), -(this.slideWidth * direction), 0)
                    } else to = this.circle(to), this.animate(index * -this.slideWidth, to * -this.slideWidth, speed);
                    this.onslide(to)
                }
            },
            getIndex: function () { return this.index },
            getNumber: function () { return this.num },
            prev: function () {
                (this.options.continuous || this.index) && this.slide(this.index - 1)
            },
            next: function () {
                (this.options.continuous || this.index < this.num - 1) && this.slide(this.index + 1)
            },
            play: function (time) {
                var that = this;
                window.clearTimeout(this.timeout), this.interval = time || this.options.slideshowInterval, this.elements[this.index] > 1 && (this.timeout = this.setTimeout(!this.requestAnimationFrame && this.slide || function (to, speed) { that.animationFrameId = that.requestAnimationFrame.call(window, function () { that.slide(to, speed) }) }, [this.index + 1, this.options.slideshowTransitionSpeed], this.interval)), this.container.addClass(this.options.playingClass)
            },
            pause: function () { window.clearTimeout(this.timeout), this.interval = null, this.container.removeClass(this.options.playingClass) },
            add: function (list) {
                var i;
                for (list.concat || (list = Array.prototype.slice.call(list)), this.list.concat || (this.list = Array.prototype.slice.call(this.list)), this.list = this.list.concat(list), this.num = this.list.length, this.num > 2 && null === this.options.continuous && (this.options.continuous = !0, this.container.removeClass(this.options.leftEdgeClass)), this.container.removeClass(this.options.rightEdgeClass).removeClass(this.options.singleClass), i = this.num - list.length; i < this.num; i += 1) this.addSlide(i), this.positionSlide(i);
                this.positions.length = this.num, this.initSlides(!0)
            },
            resetSlides: function () { this.slidesContainer.empty(), this.unloadAllSlides(), this.slides = [] },
            handleClose: function () {
                var options = this.options;
                this.destroyEventListeners(), this.pause(), this.container[0].style.display = "none", this.container.removeClass(options.displayClass).removeClass(options.singleClass).removeClass(options.leftEdgeClass).removeClass(options.rightEdgeClass), options.hidePageScrollbars && (document.body.style.overflow = this.bodyOverflowStyle), this.options.clearSlides && this.resetSlides(), this.options.onclosed && this.options.onclosed.call(this)
            },
            close: function () {
                function closeHandler(event) { event.target === that.container[0] && (that.container.off(that.support.transition.end, closeHandler), that.handleClose()) }
                var that = this;
                this.options.onclose && this.options.onclose.call(this), this.support.transition && this.options.displayTransition ? (this.container.on(this.support.transition.end, closeHandler), this.container.removeClass(this.options.displayClass)) : this.handleClose()
            },
            circle: function (index) { return (this.num + index % this.num) % this.num },
            move: function (index, dist, speed) { this.translateX(index, dist, speed), this.positions[index] = dist },
            translate: function (index, x, y, speed) {
                var style = this.slides[index].style,
                    transition = this.support.transition,
                    transform = this.support.transform;
                style[transition.name + "Duration"] = speed + "ms", style[transform.name] = "translate(" + x + "px, " + y + "px)" + (transform.translateZ ? " translateZ(0)" : "")
            },
            translateX: function (index, x, speed) { this.translate(index, x, 0, speed) },
            translateY: function (index, y, speed) { this.translate(index, 0, y, speed) },
            animate: function (from, to, speed) {
                if (!speed) return void (this.slidesContainer[0].style.left = to + "px");
                var that = this,
                    start = (new Date).getTime(),
                    timer = window.setInterval(function () { var timeElap = (new Date).getTime() - start; return timeElap > speed ? (that.slidesContainer[0].style.left = to + "px", that.ontransitionend(), void window.clearInterval(timer)) : void (that.slidesContainer[0].style.left = (to - from) * (Math.floor(timeElap / speed * 100) / 100) + from + "px") }, 4)
            },
            preventDefault: function (event) { event.preventDefault ? event.preventDefault() : event.returnValue = !1 },
            stopPropagation: function (event) { event.stopPropagation ? event.stopPropagation() : event.cancelBubble = !0 },
            onresize: function () { this.initSlides(!0) },
            onmousedown: function (event) { event.which && 1 === event.which && "VIDEO" !== event.target.nodeName && (event.preventDefault(), (event.originalEvent || event).touches = [{ pageX: event.pageX, pageY: event.pageY }], this.ontouchstart(event)) },
            onmousemove: function (event) { this.touchStart && ((event.originalEvent || event).touches = [{ pageX: event.pageX, pageY: event.pageY }], this.ontouchmove(event)) },
            onmouseup: function (event) { this.touchStart && (this.ontouchend(event), delete this.touchStart) },
            onmouseout: function (event) {
                if (this.touchStart) {
                    var target = event.target,
                        related = event.relatedTarget;
                    related && (related === target || $.contains(target, related)) || this.onmouseup(event)
                }
            },
            ontouchstart: function (event) {
                this.options.stopTouchEventsPropagation && this.stopPropagation(event);
                var touches = (event.originalEvent || event).touches[0];
                this.touchStart = { x: touches.pageX, y: touches.pageY, time: Date.now() }, this.isScrolling = void 0, this.touchDelta = {}
            },
            ontouchmove: function (event) {
                this.options.stopTouchEventsPropagation && this.stopPropagation(event);
                var touchDeltaX, indices, touches = (event.originalEvent || event).touches[0],
                    scale = (event.originalEvent || event).scale,
                    index = this.index;
                if (!(touches.length > 1 || scale && 1 !== scale))
                    if (this.options.disableScroll && event.preventDefault(), this.touchDelta = { x: touches.pageX - this.touchStart.x, y: touches.pageY - this.touchStart.y }, touchDeltaX = this.touchDelta.x, void 0 === this.isScrolling && (this.isScrolling = this.isScrolling || Math.abs(touchDeltaX) < Math.abs(this.touchDelta.y)), this.isScrolling) this.options.closeOnSwipeUpOrDown && this.translateY(index, this.touchDelta.y + this.positions[index], 0);
                    else
                        for (event.preventDefault(), window.clearTimeout(this.timeout), this.options.continuous ? indices = [this.circle(index + 1), index, this.circle(index - 1)] : (this.touchDelta.x = touchDeltaX /= !index && touchDeltaX > 0 || index === this.num - 1 && 0 > touchDeltaX ? Math.abs(touchDeltaX) / this.slideWidth + 1 : 1, indices = [index], index && indices.push(index - 1), index < this.num - 1 && indices.unshift(index + 1)); indices.length;) index = indices.pop(), this.translateX(index, touchDeltaX + this.positions[index], 0)
            },
            ontouchend: function (event) {
                this.options.stopTouchEventsPropagation && this.stopPropagation(event);
                var direction, indexForward, indexBackward, distanceForward, distanceBackward, index = this.index,
                    speed = this.options.transitionSpeed,
                    slideWidth = this.slideWidth,
                    isShortDuration = Number(Date.now() - this.touchStart.time) < 250,
                    isValidSlide = isShortDuration && Math.abs(this.touchDelta.x) > 20 || Math.abs(this.touchDelta.x) > slideWidth / 2,
                    isPastBounds = !index && this.touchDelta.x > 0 || index === this.num - 1 && this.touchDelta.x < 0,
                    isValidClose = !isValidSlide && this.options.closeOnSwipeUpOrDown && (isShortDuration && Math.abs(this.touchDelta.y) > 20 || Math.abs(this.touchDelta.y) > this.slideHeight / 2);
                this.options.continuous && (isPastBounds = !1), direction = this.touchDelta.x < 0 ? -1 : 1, this.isScrolling ? isValidClose ? this.close() : this.translateY(index, 0, speed) : isValidSlide && !isPastBounds ? (indexForward = index + direction, indexBackward = index - direction, distanceForward = slideWidth * direction, distanceBackward = -slideWidth * direction, this.options.continuous ? (this.move(this.circle(indexForward), distanceForward, 0), this.move(this.circle(index - 2 * direction), distanceBackward, 0)) : indexForward >= 0 && indexForward < this.num && this.move(indexForward, distanceForward, 0), this.move(index, this.positions[index] + distanceForward, speed), this.move(this.circle(indexBackward), this.positions[this.circle(indexBackward)] + distanceForward, speed), index = this.circle(indexBackward), this.onslide(index)) : this.options.continuous ? (this.move(this.circle(index - 1), -slideWidth, speed), this.move(index, 0, speed), this.move(this.circle(index + 1), slideWidth, speed)) : (index && this.move(index - 1, -slideWidth, speed), this.move(index, 0, speed), index < this.num - 1 && this.move(index + 1, slideWidth, speed))
            },
            ontouchcancel: function (event) { this.touchStart && (this.ontouchend(event), delete this.touchStart) },
            ontransitionend: function (event) {
                var slide = this.slides[this.index];
                event && slide !== event.target || (this.interval && this.play(), this.setTimeout(this.options.onslideend, [this.index, slide]))
            },
            oncomplete: function (event) {
                var index, target = event.target || event.srcElement,
                    parent = target && target.parentNode;
                target && parent && (index = this.getNodeIndex(parent), $(parent).removeClass(this.options.slideLoadingClass), "error" === event.type ? ($(parent).addClass(this.options.slideErrorClass), this.elements[index] = 3) : this.elements[index] = 2, target.clientHeight > this.container[0].clientHeight && (target.style.maxHeight = this.container[0].clientHeight), this.interval && this.slides[this.index] === parent && this.play(), this.setTimeout(this.options.onslidecomplete, [index, parent]))
            },
            onload: function (event) { this.oncomplete(event) },
            onerror: function (event) { this.oncomplete(event) },
            onkeydown: function (event) {
                switch (event.which || event.keyCode) {
                    case 13:
                        this.options.toggleControlsOnReturn && (this.preventDefault(event), this.toggleControls());
                        break;
                    case 27:
                        this.options.closeOnEscape && (this.close(), event.stopImmediatePropagation());
                        break;
                    case 32:
                        this.options.toggleSlideshowOnSpace && (this.preventDefault(event), this.toggleSlideshow());
                        break;
                    case 37:
                        this.options.enableKeyboardNavigation && (this.preventDefault(event), this.prev());
                        break;
                    case 39:
                        this.options.enableKeyboardNavigation && (this.preventDefault(event), this.next())
                }
            },
            handleClick: function (event) {
                function isTarget(className) { return $(target).hasClass(className) || $(parent).hasClass(className) }
                var options = this.options,
                    target = event.target || event.srcElement,
                    parent = target.parentNode;
                isTarget(options.toggleClass) ? (this.preventDefault(event), this.toggleControls()) : isTarget(options.prevClass) ? (this.preventDefault(event), this.prev()) : isTarget(options.nextClass) ? (this.preventDefault(event), this.next()) : isTarget(options.closeClass) ? (this.preventDefault(event), this.close()) : isTarget(options.playPauseClass) ? (this.preventDefault(event), this.toggleSlideshow()) : parent === this.slidesContainer[0] ? options.closeOnSlideClick ? (this.preventDefault(event), this.close()) : options.toggleControlsOnSlideClick && (this.preventDefault(event), this.toggleControls()) : parent.parentNode && parent.parentNode === this.slidesContainer[0] && options.toggleControlsOnSlideClick && (this.preventDefault(event), this.toggleControls())
            },
            onclick: function (event) { return this.options.emulateTouchEvents && this.touchDelta && (Math.abs(this.touchDelta.x) > 20 || Math.abs(this.touchDelta.y) > 20) ? void delete this.touchDelta : this.handleClick(event) },
            updateEdgeClasses: function (index) { index ? this.container.removeClass(this.options.leftEdgeClass) : this.container.addClass(this.options.leftEdgeClass), index === this.num - 1 ? this.container.addClass(this.options.rightEdgeClass) : this.container.removeClass(this.options.rightEdgeClass) },
            handleSlide: function (index) { this.options.continuous || this.updateEdgeClasses(index), this.loadElements(index), this.options.unloadElements && this.unloadElements(index), this.setTitle(index) },
            onslide: function (index) { this.index = index, this.handleSlide(index), this.setTimeout(this.options.onslide, [index, this.slides[index]]) },
            setTitle: function (index) {
                var text = this.slides[index].firstChild.title,
                    titleElement = this.titleElement;
                titleElement.length && (this.titleElement.empty(), text && titleElement[0].appendChild(document.createTextNode(text)))
            },
            setTimeout: function (func, args, wait) { var that = this; return func && window.setTimeout(function () { func.apply(that, args || []) }, wait || 0) },
            imageFactory: function (obj, callback) {
                function callbackWrapper(event) {
                    if (!called) {
                        if (event = { type: event.type, target: element }, !element.parentNode) return that.setTimeout(callbackWrapper, [event]);
                        called = !0, $(img).off("load error", callbackWrapper), backgroundSize && "load" === event.type && (element.style.background = 'url("' + url + '") center no-repeat', element.style.backgroundSize = backgroundSize), callback(event)
                    }
                }
                var called, element, title, that = this,
                    img = this.imagePrototype.cloneNode(!1),
                    url = obj,
                    backgroundSize = this.options.stretchImages;
                return "string" != typeof url && (url = this.getItemProperty(obj, this.options.urlProperty), title = this.getItemProperty(obj, this.options.titleProperty)), backgroundSize === !0 && (backgroundSize = "contain"), backgroundSize = this.support.backgroundSize && this.support.backgroundSize[backgroundSize] && backgroundSize, backgroundSize ? element = this.elementPrototype.cloneNode(!1) : (element = img, img.draggable = !1), title && (element.title = title), $(img).on("load error", callbackWrapper), img.src = url, element
            },
            createElement: function (obj, callback) {
                var type = obj && this.getItemProperty(obj, this.options.typeProperty),
                    factory = type && this[type.split("/")[0] + "Factory"] || this.imageFactory,
                    element = obj && factory.call(this, obj, callback),
                    srcset = this.getItemProperty(obj, this.options.srcsetProperty);
                return element || (element = this.elementPrototype.cloneNode(!1), this.setTimeout(callback, [{ type: "error", target: element }])), srcset && element.setAttribute("srcset", srcset), $(element).addClass(this.options.slideContentClass), element
            },
            loadElement: function (index) { this.elements[index] || (this.slides[index].firstChild ? this.elements[index] = $(this.slides[index]).hasClass(this.options.slideErrorClass) ? 3 : 2 : (this.elements[index] = 1, $(this.slides[index]).addClass(this.options.slideLoadingClass), this.slides[index].appendChild(this.createElement(this.list[index], this.proxyListener)))) },
            loadElements: function (index) {
                var i, limit = Math.min(this.num, 2 * this.options.preloadRange + 1),
                    j = index;
                for (i = 0; limit > i; i += 1) j += i * (i % 2 === 0 ? -1 : 1), j = this.circle(j), this.loadElement(j)
            },
            unloadElements: function (index) { var i, diff; for (i in this.elements) this.elements.hasOwnProperty(i) && (diff = Math.abs(index - i), diff > this.options.preloadRange && diff + this.options.preloadRange < this.num && (this.unloadSlide(i), delete this.elements[i])) },
            addSlide: function (index) {
                var slide = this.slidePrototype.cloneNode(!1);
                slide.setAttribute("data-index", index), this.slidesContainer[0].appendChild(slide), this.slides.push(slide)
            },
            positionSlide: function (index) {
                var slide = this.slides[index];
                slide.style.width = this.slideWidth + "px", this.support.transform && (slide.style.left = index * -this.slideWidth + "px", this.move(index, this.index > index ? -this.slideWidth : this.index < index ? this.slideWidth : 0, 0))
            },
            initSlides: function (reload) {
                var clearSlides, i;
                for (reload || (this.positions = [], this.positions.length = this.num, this.elements = {}, this.imagePrototype = document.createElement("img"), this.elementPrototype = document.createElement("div"), this.slidePrototype = document.createElement("div"), $(this.slidePrototype).addClass(this.options.slideClass), this.slides = this.slidesContainer[0].children, clearSlides = this.options.clearSlides || this.slides.length !== this.num), this.slideWidth = this.container[0].offsetWidth, this.slideHeight = this.container[0].offsetHeight, this.slidesContainer[0].style.width = this.num * this.slideWidth + "px", clearSlides && this.resetSlides(), i = 0; i < this.num; i += 1) clearSlides && this.addSlide(i), this.positionSlide(i);
                this.options.continuous && this.support.transform && (this.move(this.circle(this.index - 1), -this.slideWidth, 0), this.move(this.circle(this.index + 1), this.slideWidth, 0)), this.support.transform || (this.slidesContainer[0].style.left = this.index * -this.slideWidth + "px")
            },
            unloadSlide: function (index) {
                var slide, firstChild;
                slide = this.slides[index], firstChild = slide.firstChild, null !== firstChild && slide.removeChild(firstChild)
            },
            unloadAllSlides: function () { var i, len; for (i = 0, len = this.slides.length; len > i; i++) this.unloadSlide(i) },
            toggleControls: function () {
                var controlsClass = this.options.controlsClass;
                this.container.hasClass(controlsClass) ? this.container.removeClass(controlsClass) : this.container.addClass(controlsClass)
            },
            toggleSlideshow: function () { this.interval ? this.pause() : this.play() },
            getNodeIndex: function (element) { return parseInt(element.getAttribute("data-index"), 10) },
            getNestedProperty: function (obj, property) {
                return property.replace(/\[(?:'([^']+)'|"([^"]+)"|(\d+))\]|(?:(?:^|\.)([^\.\[]+))/g, function (str, singleQuoteProp, doubleQuoteProp, arrayIndex, dotProp) {
                    var prop = dotProp || singleQuoteProp || doubleQuoteProp || arrayIndex && parseInt(arrayIndex, 10);
                    str && obj && (obj = obj[prop])
                }), obj
            },
            getDataProperty: function (obj, property) {
                if (obj.getAttribute) {
                    var prop = obj.getAttribute("data-" + property.replace(/([A-Z])/g, "-$1").toLowerCase());
                    if ("string" == typeof prop) {
                        if (/^(true|false|null|-?\d+(\.\d+)?|\{[\s\S]*\}|\[[\s\S]*\])$/.test(prop)) try { return $.parseJSON(prop) } catch (ignore) { }
                        return prop
                    }
                }
            },
            getItemProperty: function (obj, property) { var prop = obj[property]; return void 0 === prop && (prop = this.getDataProperty(obj, property), void 0 === prop && (prop = this.getNestedProperty(obj, property))), prop },
            initStartIndex: function () {
                var i, index = this.options.index,
                    urlProperty = this.options.urlProperty;
                if (index && "number" != typeof index)
                    for (i = 0; i < this.num; i += 1)
                        if (this.list[i] === index || this.getItemProperty(this.list[i], urlProperty) === this.getItemProperty(index, urlProperty)) { index = i; break }
                this.index = this.circle(parseInt(index, 10) || 0)
            },
            initEventListeners: function () {
                function proxyListener(event) {
                    var type = that.support.transition && that.support.transition.end === event.type ? "transitionend" : event.type;
                    that["on" + type](event)
                }
                var that = this,
                    slidesContainer = this.slidesContainer;
                $(window).on("resize", proxyListener), $(document.body).on("keydown", proxyListener), this.container.on("click", proxyListener), this.support.touch ? slidesContainer.on("touchstart touchmove touchend touchcancel", proxyListener) : this.options.emulateTouchEvents && this.support.transition && slidesContainer.on("mousedown mousemove mouseup mouseout", proxyListener), this.support.transition && slidesContainer.on(this.support.transition.end, proxyListener), this.proxyListener = proxyListener
            },
            destroyEventListeners: function () {
                var slidesContainer = this.slidesContainer,
                    proxyListener = this.proxyListener;
                $(window).off("resize", proxyListener), $(document.body).off("keydown", proxyListener), this.container.off("click", proxyListener), this.support.touch ? slidesContainer.off("touchstart touchmove touchend touchcancel", proxyListener) : this.options.emulateTouchEvents && this.support.transition && slidesContainer.off("mousedown mousemove mouseup mouseout", proxyListener), this.support.transition && slidesContainer.off(this.support.transition.end, proxyListener)
            },
            handleOpen: function () { this.options.onopened && this.options.onopened.call(this) },
            initWidget: function () {
                function openHandler(event) { event.target === that.container[0] && (that.container.off(that.support.transition.end, openHandler), that.handleOpen()) }
                var that = this;
                return this.container = $(this.options.container), this.container.length ? (this.slidesContainer = this.container.find(this.options.slidesContainer).first(), this.slidesContainer.length ? (this.titleElement = this.container.find(this.options.titleElement).first(), 1 === this.num && this.container.addClass(this.options.singleClass), this.options.onopen && this.options.onopen.call(this), this.support.transition && this.options.displayTransition ? this.container.on(this.support.transition.end, openHandler) : this.handleOpen(), this.options.hidePageScrollbars && (this.bodyOverflowStyle = document.body.style.overflow, document.body.style.overflow = "hidden"), this.container[0].style.display = "block", this.initSlides(), void this.container.addClass(this.options.displayClass)) : (this.console.log("blueimp Gallery: Slides container not found.", this.options.slidesContainer), !1)) : (this.console.log("blueimp Gallery: Widget container not found.", this.options.container), !1)
            },
            initOptions: function (options) { this.options = $.extend({}, this.options), (options && options.carousel || this.options.carousel && (!options || options.carousel !== !1)) && $.extend(this.options, this.carouselOptions), $.extend(this.options, options), this.num < 3 && (this.options.continuous = this.options.continuous ? null : !1), this.support.transition || (this.options.emulateTouchEvents = !1), this.options.event && this.preventDefault(this.options.event) }
        }), Gallery
    }),
    function (factory) { "use strict"; "function" == typeof define && define.amd ? define(["jquery", "./blueimp-gallery"], factory) : factory(window.jQuery, window.blueimp.Gallery) }(function ($, Gallery) {
        "use strict";
        $(document).on("click", "[data-gallery]", function (event) {
            var id = $(this).data("gallery"),
                widget = $(id),
                container = widget.length && widget || $(Gallery.prototype.options.container),
                callbacks = { onopen: function () { container.data("gallery", this).trigger("open") }, onopened: function () { container.trigger("opened") }, onslide: function () { container.trigger("slide", arguments) }, onslideend: function () { container.trigger("slideend", arguments) }, onslidecomplete: function () { container.trigger("slidecomplete", arguments) }, onclose: function () { container.trigger("close") }, onclosed: function () { container.trigger("closed").removeData("gallery") } },
                options = $.extend(container.data(), { container: container[0], index: this, event: event }, callbacks),
                links = $('[data-gallery="' + id + '"]');
            return options.filter && (links = links.filter(options.filter)), new Gallery(links, options)
        })
    }),
    function () {
        var initializing = !1;
        window.JQClass = function () { }, JQClass.classes = {}, JQClass.extend = function extender(prop) {
            function JQClass() { !initializing && this._init && this._init.apply(this, arguments) }
            var base = this.prototype;
            initializing = !0;
            var prototype = new this;
            initializing = !1;
            for (var name in prop) prototype[name] = "function" == typeof prop[name] && "function" == typeof base[name] ? function (name, fn) {
                return function () {
                    var __super = this._super;
                    this._super = function (args) { return base[name].apply(this, args || []) };
                    var ret = fn.apply(this, arguments);
                    return this._super = __super, ret
                }
            }(name, prop[name]) : prop[name];
            return JQClass.prototype = prototype, JQClass.prototype.constructor = JQClass, JQClass.extend = extender, JQClass
        }
    }(),
    function ($) {
        function camelCase(name) { return name.replace(/-([a-z])/g, function (match, group) { return group.toUpperCase() }) }
        JQClass.classes.JQPlugin = JQClass.extend({
            name: "plugin",
            defaultOptions: {},
            regionalOptions: {},
            _getters: [],
            _getMarker: function () { return "is-" + this.name },
            _init: function () {
                $.extend(this.defaultOptions, this.regionalOptions && this.regionalOptions[""] || {});
                var jqName = camelCase(this.name);
                $[jqName] = this, $.fn[jqName] = function (options) {
                    var otherArgs = Array.prototype.slice.call(arguments, 1);
                    return $[jqName]._isNotChained(options, otherArgs) ? $[jqName][options].apply($[jqName], [this[0]].concat(otherArgs)) : this.each(function () {
                        if ("string" == typeof options) {
                            if ("_" === options[0] || !$[jqName][options]) throw "Unknown method: " + options;
                            $[jqName][options].apply($[jqName], [this].concat(otherArgs))
                        } else $[jqName]._attach(this, options)
                    })
                }
            },
            setDefaults: function (options) { $.extend(this.defaultOptions, options || {}) },
            _isNotChained: function (name, otherArgs) { return "option" === name && (0 === otherArgs.length || 1 === otherArgs.length && "string" == typeof otherArgs[0]) ? !0 : $.inArray(name, this._getters) > -1 },
            _attach: function (elem, options) {
                if (elem = $(elem), !elem.hasClass(this._getMarker())) {
                    elem.addClass(this._getMarker()), options = $.extend({}, this.defaultOptions, this._getMetadata(elem), options || {});
                    var inst = $.extend({ name: this.name, elem: elem, options: options }, this._instSettings(elem, options));
                    elem.data(this.name, inst), this._postAttach(elem, inst), this.option(elem, options)
                }
            },
            _instSettings: function () { return {} },
            _postAttach: function () { },
            _getMetadata: function (elem) {
                try {
                    var data = elem.data(this.name.toLowerCase()) || "";
                    data = data.replace(/'/g, '"'), data = data.replace(/([a-zA-Z0-9]+):/g, function (match, group, i) { var count = data.substring(0, i).match(/"/g); return count && count.length % 2 !== 0 ? group + ":" : '"' + group + '":' }), data = $.parseJSON("{" + data + "}");
                    for (var name in data) { var value = data[name]; "string" == typeof value && value.match(/^new Date\((.*)\)$/) && (data[name] = eval(value)) }
                    return data
                } catch (e) { return {} }
            },
            _getInst: function (elem) { return $(elem).data(this.name) || {} },
            option: function (elem, name, value) { elem = $(elem); var inst = elem.data(this.name); if (!name || "string" == typeof name && null == value) { var options = (inst || {}).options; return options && name ? options[name] : options } if (elem.hasClass(this._getMarker())) { var options = name || {}; "string" == typeof name && (options = {}, options[name] = value), this._optionsChanged(elem, inst, options), $.extend(inst.options, options) } },
            _optionsChanged: function () { },
            destroy: function (elem) { elem = $(elem), elem.hasClass(this._getMarker()) && (this._preDestroy(elem, this._getInst(elem)), elem.removeData(this.name).removeClass(this._getMarker())) },
            _preDestroy: function () { }
        }), $.JQPlugin = {
            createPlugin: function (superClass, overrides) {
                "object" == typeof superClass && (overrides = superClass, superClass = "JQPlugin"), superClass = camelCase(superClass);
                var className = camelCase(overrides.name);
                JQClass.classes[className] = JQClass.classes[superClass].extend(overrides), new JQClass.classes[className]
            }
        }
    }(jQuery),
    function ($) {
        var pluginName = "countdown",
            Y = 0,
            O = 1,
            W = 2,
            D = 3,
            H = 4,
            M = 5,
            S = 6;
        $.JQPlugin.createPlugin({
            name: pluginName,
            defaultOptions: { until: null, since: null, timezone: null, serverSync: null, format: "dHMS", layout: "", compact: !1, padZeroes: !1, significant: 0, description: "", expiryUrl: "", expiryText: "", alwaysExpire: !1, onExpiry: null, onTick: null, tickInterval: 1 },
            regionalOptions: { "": { labels: ["Years", "Months", "Weeks", "Days", "Hours", "Minutes", "Seconds"], labels1: ["Year", "Month", "Week", "Day", "Hour", "Minute", "Second"], compactLabels: ["y", "m", "w", "d"], whichLabels: null, digits: ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"], timeSeparator: ":", isRTL: !1 } },
            _getters: ["getTimes"],
            _rtlClass: pluginName + "-rtl",
            _sectionClass: pluginName + "-section",
            _amountClass: pluginName + "-amount",
            _periodClass: pluginName + "-period",
            _rowClass: pluginName + "-row",
            _holdingClass: pluginName + "-holding",
            _showClass: pluginName + "-show",
            _descrClass: pluginName + "-descr",
            _timerElems: [],
            _init: function () {
                function timerCallBack(timestamp) {
                    var drawStart = 1e12 > timestamp ? perfAvail ? performance.now() + performance.timing.navigationStart : now() : timestamp || now();
                    drawStart - animationStartTime >= 1e3 && (self._updateElems(), animationStartTime = drawStart), requestAnimationFrame(timerCallBack)
                }
                var self = this;
                this._super(), this._serverSyncs = [];
                var now = "function" == typeof Date.now ? Date.now : function () { return (new Date).getTime() },
                    perfAvail = window.performance && "function" == typeof window.performance.now,
                    requestAnimationFrame = window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || window.oRequestAnimationFrame || window.msRequestAnimationFrame || null,
                    animationStartTime = 0;
                !requestAnimationFrame || $.noRequestAnimationFrame ? ($.noRequestAnimationFrame = null, setInterval(function () { self._updateElems() }, 980)) : (animationStartTime = window.animationStartTime || window.webkitAnimationStartTime || window.mozAnimationStartTime || window.oAnimationStartTime || window.msAnimationStartTime || now(),
                    requestAnimationFrame(timerCallBack))
            },
            UTCDate: function (tz, year, month, day, hours, mins, secs, ms) { "object" == typeof year && year.constructor == Date && (ms = year.getMilliseconds(), secs = year.getSeconds(), mins = year.getMinutes(), hours = year.getHours(), day = year.getDate(), month = year.getMonth(), year = year.getFullYear()); var d = new Date; return d.setUTCFullYear(year), d.setUTCDate(1), d.setUTCMonth(month || 0), d.setUTCDate(day || 1), d.setUTCHours(hours || 0), d.setUTCMinutes((mins || 0) - (Math.abs(tz) < 30 ? 60 * tz : tz)), d.setUTCSeconds(secs || 0), d.setUTCMilliseconds(ms || 0), d },
            periodsToSeconds: function (periods) { return 31557600 * periods[0] + 2629800 * periods[1] + 604800 * periods[2] + 86400 * periods[3] + 3600 * periods[4] + 60 * periods[5] + periods[6] },
            _instSettings: function () { return { _periods: [0, 0, 0, 0, 0, 0, 0] } },
            _addElem: function (elem) { this._hasElem(elem) || this._timerElems.push(elem) },
            _hasElem: function (elem) { return $.inArray(elem, this._timerElems) > -1 },
            _removeElem: function (elem) { this._timerElems = $.map(this._timerElems, function (value) { return value == elem ? null : value }) },
            _updateElems: function () { for (var i = this._timerElems.length - 1; i >= 0; i--) this._updateCountdown(this._timerElems[i]) },
            _optionsChanged: function (elem, inst, options) {
                options.layout && (options.layout = options.layout.replace(/&lt;/g, "<").replace(/&gt;/g, ">")), this._resetExtraLabels(inst.options, options);
                var timezoneChanged = inst.options.timezone != options.timezone;
                $.extend(inst.options, options), this._adjustSettings(elem, inst, null != options.until || null != options.since || timezoneChanged);
                var now = new Date;
                (inst._since && inst._since < now || inst._until && inst._until > now) && this._addElem(elem[0]), this._updateCountdown(elem, inst)
            },
            _updateCountdown: function (elem, inst) {
                if (elem = elem.jquery ? elem : $(elem), inst = inst || this._getInst(elem)) {
                    if (elem.html(this._generateHTML(inst)).toggleClass(this._rtlClass, inst.options.isRTL), $.isFunction(inst.options.onTick)) {
                        var periods = "lap" != inst._hold ? inst._periods : this._calculatePeriods(inst, inst._show, inst.options.significant, new Date);
                        1 != inst.options.tickInterval && this.periodsToSeconds(periods) % inst.options.tickInterval != 0 || inst.options.onTick.apply(elem[0], [periods])
                    }
                    var expired = "pause" != inst._hold && (inst._since ? inst._now.getTime() < inst._since.getTime() : inst._now.getTime() >= inst._until.getTime());
                    if (expired && !inst._expiring) {
                        if (inst._expiring = !0, this._hasElem(elem[0]) || inst.options.alwaysExpire) {
                            if (this._removeElem(elem[0]), $.isFunction(inst.options.onExpiry) && inst.options.onExpiry.apply(elem[0], []), inst.options.expiryText) {
                                var layout = inst.options.layout;
                                inst.options.layout = inst.options.expiryText, this._updateCountdown(elem[0], inst), inst.options.layout = layout
                            }
                            inst.options.expiryUrl && (window.location = inst.options.expiryUrl)
                        }
                        inst._expiring = !1
                    } else "pause" == inst._hold && this._removeElem(elem[0])
                }
            },
            _resetExtraLabels: function (base, options) { for (var n in options) n.match(/[Ll]abels[02-9]|compactLabels1/) && (base[n] = options[n]); for (var n in base) n.match(/[Ll]abels[02-9]|compactLabels1/) && "undefined" == typeof options[n] && (base[n] = null) },
            _adjustSettings: function (elem, inst, recalc) {
                for (var now, serverOffset = 0, serverEntry = null, i = 0; i < this._serverSyncs.length; i++)
                    if (this._serverSyncs[i][0] == inst.options.serverSync) { serverEntry = this._serverSyncs[i][1]; break }
                if (null != serverEntry) serverOffset = inst.options.serverSync ? serverEntry : 0, now = new Date;
                else {
                    var serverResult = $.isFunction(inst.options.serverSync) ? inst.options.serverSync.apply(elem[0], []) : null;
                    now = new Date, serverOffset = serverResult ? now.getTime() - serverResult.getTime() : 0, this._serverSyncs.push([inst.options.serverSync, serverOffset])
                }
                var timezone = inst.options.timezone;
                timezone = null == timezone ? -now.getTimezoneOffset() : timezone, (recalc || !recalc && null == inst._until && null == inst._since) && (inst._since = inst.options.since, null != inst._since && (inst._since = this.UTCDate(timezone, this._determineTime(inst._since, null)), inst._since && serverOffset && inst._since.setMilliseconds(inst._since.getMilliseconds() + serverOffset)), inst._until = this.UTCDate(timezone, this._determineTime(inst.options.until, now)), serverOffset && inst._until.setMilliseconds(inst._until.getMilliseconds() + serverOffset)), inst._show = this._determineShow(inst)
            },
            _preDestroy: function (elem) { this._removeElem(elem[0]), elem.empty() },
            pause: function (elem) { this._hold(elem, "pause") },
            lap: function (elem) { this._hold(elem, "lap") },
            resume: function (elem) { this._hold(elem, null) },
            toggle: function (elem) {
                var inst = $.data(elem, this.name) || {};
                this[inst._hold ? "resume" : "pause"](elem)
            },
            toggleLap: function (elem) {
                var inst = $.data(elem, this.name) || {};
                this[inst._hold ? "resume" : "lap"](elem)
            },
            _hold: function (elem, hold) {
                var inst = $.data(elem, this.name);
                if (inst) {
                    if ("pause" == inst._hold && !hold) {
                        inst._periods = inst._savePeriods;
                        var sign = inst._since ? "-" : "+";
                        inst[inst._since ? "_since" : "_until"] = this._determineTime(sign + inst._periods[0] + "y" + sign + inst._periods[1] + "o" + sign + inst._periods[2] + "w" + sign + inst._periods[3] + "d" + sign + inst._periods[4] + "h" + sign + inst._periods[5] + "m" + sign + inst._periods[6] + "s"), this._addElem(elem)
                    }
                    inst._hold = hold, inst._savePeriods = "pause" == hold ? inst._periods : null, $.data(elem, this.name, inst), this._updateCountdown(elem, inst)
                }
            },
            getTimes: function (elem) { var inst = $.data(elem, this.name); return inst ? "pause" == inst._hold ? inst._savePeriods : inst._hold ? this._calculatePeriods(inst, inst._show, inst.options.significant, new Date) : inst._periods : null },
            _determineTime: function (setting, defaultTime) {
                var self = this,
                    offsetNumeric = function (offset) { var time = new Date; return time.setTime(time.getTime() + 1e3 * offset), time },
                    offsetString = function (offset) {
                        offset = offset.toLowerCase();
                        for (var time = new Date, year = time.getFullYear(), month = time.getMonth(), day = time.getDate(), hour = time.getHours(), minute = time.getMinutes(), second = time.getSeconds(), pattern = /([+-]?[0-9]+)\s*(s|m|h|d|w|o|y)?/g, matches = pattern.exec(offset); matches;) {
                            switch (matches[2] || "s") {
                                case "s":
                                    second += parseInt(matches[1], 10);
                                    break;
                                case "m":
                                    minute += parseInt(matches[1], 10);
                                    break;
                                case "h":
                                    hour += parseInt(matches[1], 10);
                                    break;
                                case "d":
                                    day += parseInt(matches[1], 10);
                                    break;
                                case "w":
                                    day += 7 * parseInt(matches[1], 10);
                                    break;
                                case "o":
                                    month += parseInt(matches[1], 10), day = Math.min(day, self._getDaysInMonth(year, month));
                                    break;
                                case "y":
                                    year += parseInt(matches[1], 10), day = Math.min(day, self._getDaysInMonth(year, month))
                            }
                            matches = pattern.exec(offset)
                        }
                        return new Date(year, month, day, hour, minute, second, 0)
                    },
                    time = null == setting ? defaultTime : "string" == typeof setting ? offsetString(setting) : "number" == typeof setting ? offsetNumeric(setting) : setting;
                return time && time.setMilliseconds(0), time
            },
            _getDaysInMonth: function (year, month) { return 32 - new Date(year, month, 32).getDate() },
            _normalLabels: function (num) { return num },
            _generateHTML: function (inst) {
                var self = this;
                inst._periods = inst._hold ? inst._periods : this._calculatePeriods(inst, inst._show, inst.options.significant, new Date);
                for (var shownNonZero = !1, showCount = 0, sigCount = inst.options.significant, show = $.extend({}, inst._show), period = Y; S >= period; period++) shownNonZero |= "?" == inst._show[period] && inst._periods[period] > 0, show[period] = "?" != inst._show[period] || shownNonZero ? inst._show[period] : null, showCount += show[period] ? 1 : 0, sigCount -= inst._periods[period] > 0 ? 1 : 0;
                for (var showSignificant = [!1, !1, !1, !1, !1, !1, !1], period = S; period >= Y; period--) inst._show[period] && (inst._periods[period] ? showSignificant[period] = !0 : (showSignificant[period] = sigCount > 0, sigCount--));
                var labels = inst.options.compact ? inst.options.compactLabels : inst.options.labels,
                    whichLabels = inst.options.whichLabels || this._normalLabels,
                    showCompact = function (period) { var labelsNum = inst.options["compactLabels" + whichLabels(inst._periods[period])]; return show[period] ? self._translateDigits(inst, inst._periods[period]) + (labelsNum ? labelsNum[period] : labels[period]) + " " : "" },
                    minDigits = inst.options.padZeroes ? 2 : 1,
                    showFull = function (period) { var labelsNum = inst.options["labels" + whichLabels(inst._periods[period])]; return !inst.options.significant && show[period] || inst.options.significant && showSignificant[period] ? '<span class="' + self._sectionClass + '"><span class="' + self._amountClass + '">' + self._minDigits(inst, inst._periods[period], minDigits) + '</span><span class="' + self._periodClass + '">' + (labelsNum ? labelsNum[period] : labels[period]) + "</span></span>" : "" };
                return inst.options.layout ? this._buildLayout(inst, show, inst.options.layout, inst.options.compact, inst.options.significant, showSignificant) : (inst.options.compact ? '<span class="' + this._rowClass + " " + this._amountClass + (inst._hold ? " " + this._holdingClass : "") + '">' + showCompact(Y) + showCompact(O) + showCompact(W) + showCompact(D) + (show[H] ? this._minDigits(inst, inst._periods[H], 2) : "") + (show[M] ? (show[H] ? inst.options.timeSeparator : "") + this._minDigits(inst, inst._periods[M], 2) : "") + (show[S] ? (show[H] || show[M] ? inst.options.timeSeparator : "") + this._minDigits(inst, inst._periods[S], 2) : "") : '<span class="' + this._rowClass + " " + this._showClass + (inst.options.significant || showCount) + (inst._hold ? " " + this._holdingClass : "") + '">' + showFull(Y) + showFull(O) + showFull(W) + showFull(D) + showFull(H) + showFull(M) + showFull(S)) + "</span>" + (inst.options.description ? '<span class="' + this._rowClass + " " + this._descrClass + '">' + inst.options.description + "</span>" : "")
            },
            _buildLayout: function (inst, show, layout, compact, significant, showSignificant) {
                for (var labels = inst.options[compact ? "compactLabels" : "labels"], whichLabels = inst.options.whichLabels || this._normalLabels, labelFor = function (index) { return (inst.options[(compact ? "compactLabels" : "labels") + whichLabels(inst._periods[index])] || labels)[index] }, digit = function (value, position) { return inst.options.digits[Math.floor(value / position) % 10] }, subs = { desc: inst.options.description, sep: inst.options.timeSeparator, yl: labelFor(Y), yn: this._minDigits(inst, inst._periods[Y], 1), ynn: this._minDigits(inst, inst._periods[Y], 2), ynnn: this._minDigits(inst, inst._periods[Y], 3), y1: digit(inst._periods[Y], 1), y10: digit(inst._periods[Y], 10), y100: digit(inst._periods[Y], 100), y1000: digit(inst._periods[Y], 1e3), ol: labelFor(O), on: this._minDigits(inst, inst._periods[O], 1), onn: this._minDigits(inst, inst._periods[O], 2), onnn: this._minDigits(inst, inst._periods[O], 3), o1: digit(inst._periods[O], 1), o10: digit(inst._periods[O], 10), o100: digit(inst._periods[O], 100), o1000: digit(inst._periods[O], 1e3), wl: labelFor(W), wn: this._minDigits(inst, inst._periods[W], 1), wnn: this._minDigits(inst, inst._periods[W], 2), wnnn: this._minDigits(inst, inst._periods[W], 3), w1: digit(inst._periods[W], 1), w10: digit(inst._periods[W], 10), w100: digit(inst._periods[W], 100), w1000: digit(inst._periods[W], 1e3), dl: labelFor(D), dn: this._minDigits(inst, inst._periods[D], 1), dnn: this._minDigits(inst, inst._periods[D], 2), dnnn: this._minDigits(inst, inst._periods[D], 3), d1: digit(inst._periods[D], 1), d10: digit(inst._periods[D], 10), d100: digit(inst._periods[D], 100), d1000: digit(inst._periods[D], 1e3), hl: labelFor(H), hn: this._minDigits(inst, inst._periods[H], 1), hnn: this._minDigits(inst, inst._periods[H], 2), hnnn: this._minDigits(inst, inst._periods[H], 3), h1: digit(inst._periods[H], 1), h10: digit(inst._periods[H], 10), h100: digit(inst._periods[H], 100), h1000: digit(inst._periods[H], 1e3), ml: labelFor(M), mn: this._minDigits(inst, inst._periods[M], 1), mnn: this._minDigits(inst, inst._periods[M], 2), mnnn: this._minDigits(inst, inst._periods[M], 3), m1: digit(inst._periods[M], 1), m10: digit(inst._periods[M], 10), m100: digit(inst._periods[M], 100), m1000: digit(inst._periods[M], 1e3), sl: labelFor(S), sn: this._minDigits(inst, inst._periods[S], 1), snn: this._minDigits(inst, inst._periods[S], 2), snnn: this._minDigits(inst, inst._periods[S], 3), s1: digit(inst._periods[S], 1), s10: digit(inst._periods[S], 10), s100: digit(inst._periods[S], 100), s1000: digit(inst._periods[S], 1e3) }, html = layout, i = Y; S >= i; i++) {
                    var period = "yowdhms".charAt(i),
                        re = new RegExp("\\{" + period + "<\\}([\\s\\S]*)\\{" + period + ">\\}", "g");
                    html = html.replace(re, !significant && show[i] || significant && showSignificant[i] ? "$1" : "")
                }
                return $.each(subs, function (n, v) {
                    var re = new RegExp("\\{" + n + "\\}", "g");
                    html = html.replace(re, v)
                }), html
            },
            _minDigits: function (inst, value, len) { return value = "" + value, value.length >= len ? this._translateDigits(inst, value) : (value = "0000000000" + value, this._translateDigits(inst, value.substr(value.length - len))) },
            _translateDigits: function (inst, value) { return ("" + value).replace(/[0-9]/g, function (digit) { return inst.options.digits[digit] }) },
            _determineShow: function (inst) {
                var format = inst.options.format,
                    show = [];
                return show[Y] = format.match("y") ? "?" : format.match("Y") ? "!" : null, show[O] = format.match("o") ? "?" : format.match("O") ? "!" : null, show[W] = format.match("w") ? "?" : format.match("W") ? "!" : null, show[D] = format.match("d") ? "?" : format.match("D") ? "!" : null, show[H] = format.match("h") ? "?" : format.match("H") ? "!" : null, show[M] = format.match("m") ? "?" : format.match("M") ? "!" : null, show[S] = format.match("s") ? "?" : format.match("S") ? "!" : null, show
            },
            _calculatePeriods: function (inst, show, significant, now) {
                inst._now = now, inst._now.setMilliseconds(0);
                var until = new Date(inst._now.getTime());
                inst._since ? now.getTime() < inst._since.getTime() ? inst._now = now = until : now = inst._since : (until.setTime(inst._until.getTime()), now.getTime() > inst._until.getTime() && (inst._now = now = until));
                var periods = [0, 0, 0, 0, 0, 0, 0];
                if (show[Y] || show[O]) {
                    var lastNow = this._getDaysInMonth(now.getFullYear(), now.getMonth()),
                        lastUntil = this._getDaysInMonth(until.getFullYear(), until.getMonth()),
                        sameDay = until.getDate() == now.getDate() || until.getDate() >= Math.min(lastNow, lastUntil) && now.getDate() >= Math.min(lastNow, lastUntil),
                        getSecs = function (date) { return 60 * (60 * date.getHours() + date.getMinutes()) + date.getSeconds() },
                        months = Math.max(0, 12 * (until.getFullYear() - now.getFullYear()) + until.getMonth() - now.getMonth() + (until.getDate() < now.getDate() && !sameDay || sameDay && getSecs(until) < getSecs(now) ? -1 : 0));
                    periods[Y] = show[Y] ? Math.floor(months / 12) : 0, periods[O] = show[O] ? months - 12 * periods[Y] : 0, now = new Date(now.getTime());
                    var wasLastDay = now.getDate() == lastNow,
                        lastDay = this._getDaysInMonth(now.getFullYear() + periods[Y], now.getMonth() + periods[O]);
                    now.getDate() > lastDay && now.setDate(lastDay), now.setFullYear(now.getFullYear() + periods[Y]), now.setMonth(now.getMonth() + periods[O]), wasLastDay && now.setDate(lastDay)
                }
                var diff = Math.floor((until.getTime() - now.getTime()) / 1e3),
                    extractPeriod = function (period, numSecs) { periods[period] = show[period] ? Math.floor(diff / numSecs) : 0, diff -= periods[period] * numSecs };
                if (extractPeriod(W, 604800), extractPeriod(D, 86400), extractPeriod(H, 3600), extractPeriod(M, 60), extractPeriod(S, 1), diff > 0 && !inst._since)
                    for (var multiplier = [1, 12, 4.3482, 7, 24, 60, 60], lastShown = S, max = 1, period = S; period >= Y; period--) show[period] && (periods[lastShown] >= max && (periods[lastShown] = 0, diff = 1), diff > 0 && (periods[period]++, diff = 0, lastShown = period, max = 1)), max *= multiplier[period];
                if (significant)
                    for (var period = Y; S >= period; period++) significant && periods[period] ? significant-- : significant || (periods[period] = 0);
                return periods
            }
        })
    }(jQuery),
    function ($) {
        $.countdown.regionalOptions.ru = {
            labels: ["\u041b\u0435\u0442", "\u041c\u0435\u0441\u044f\u0446\u0435\u0432", "\u041d\u0435\u0434\u0435\u043b\u044c", "\u0414\u043d\u0435\u0439", "\u0427\u0430\u0441\u043e\u0432", "\u041c\u0438\u043d\u0443\u0442", "\u0421\u0435\u043a\u0443\u043d\u0434"],
            labels1: ["\u0413\u043e\u0434", "\u041c\u0435\u0441\u044f\u0446", "\u041d\u0435\u0434\u0435\u043b\u044f", "\u0414\u0435\u043d\u044c", "\u0427\u0430\u0441", "\u041c\u0438\u043d\u0443\u0442\u0430", "\u0421\u0435\u043a\u0443\u043d\u0434\u0430"],
            labels2: ["\u0413\u043e\u0434\u0430", "\u041c\u0435\u0441\u044f\u0446\u0430", "\u041d\u0435\u0434\u0435\u043b\u0438", "\u0414\u043d\u044f", "\u0427\u0430\u0441\u0430", "\u041c\u0438\u043d\u0443\u0442\u044b", "\u0421\u0435\u043a\u0443\u043d\u0434\u044b"],
            compactLabels: ["\u043b", "\u043c", "\u043d", "\u0434"],
            compactLabels1: ["\u0433", "\u043c", "\u043d", "\u0434"],
            whichLabels: function (amount) {
                var units = amount % 10,
                    tens = Math.floor(amount % 100 / 10);
                return 1 == amount ? 1 : units >= 2 && 4 >= units && 1 != tens ? 2 : 1 == units && 1 != tens ? 1 : 0
            },
            digits: ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"],
            timeSeparator: ":",
            isRTL: !1
        }, $.countdown.setDefaults($.countdown.regionalOptions.ru)
    }(jQuery),




    /* ========================================================================
     * Bootstrap: button.js v3.3.6
     * http://getbootstrap.com/javascript/#buttons
     * ========================================================================
     * Copyright 2011-2015 Twitter, Inc.
     * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
     * ======================================================================== */
    + function ($) {
        "use strict";

        function Plugin(option) {
            return this.each(function () {
                var $this = $(this),
                    data = $this.data("bs.button"),
                    options = "object" == typeof option && option;
                data || $this.data("bs.button", data = new Button(this, options)), "toggle" == option ? data.toggle() : option && data.setState(option)
            })
        }
        var Button = function (element, options) { this.$element = $(element), this.options = $.extend({}, Button.DEFAULTS, options), this.isLoading = !1 };
        Button.VERSION = "3.3.6", Button.DEFAULTS = { loadingText: "loading..." }, Button.prototype.setState = function (state) {
            var d = "disabled",
                $el = this.$element,
                val = $el.is("input") ? "val" : "html",
                data = $el.data();
            state += "Text", null == data.resetText && $el.data("resetText", $el[val]()), setTimeout($.proxy(function () { $el[val](null == data[state] ? this.options[state] : data[state]), "loadingText" == state ? (this.isLoading = !0, $el.addClass(d).attr(d, d)) : this.isLoading && (this.isLoading = !1, $el.removeClass(d).removeAttr(d)) }, this), 0)
        }, Button.prototype.toggle = function () {
            var changed = !0,
                $parent = this.$element.closest('[data-toggle="buttons"]');
            if ($parent.length) { var $input = this.$element.find("input"); "radio" == $input.prop("type") ? ($input.prop("checked") && (changed = !1), $parent.find(".active").removeClass("active"), this.$element.addClass("active")) : "checkbox" == $input.prop("type") && ($input.prop("checked") !== this.$element.hasClass("active") && (changed = !1), this.$element.toggleClass("active")), $input.prop("checked", this.$element.hasClass("active")), changed && $input.trigger("change") } else this.$element.attr("aria-pressed", !this.$element.hasClass("active")), this.$element.toggleClass("active")
        };
        var old = $.fn.button;
        $.fn.button = Plugin, $.fn.button.Constructor = Button, $.fn.button.noConflict = function () { return $.fn.button = old, this }, $(document).on("click.bs.button.data-api", '[data-toggle^="button"]', function (e) {
            var $btn = $(e.target);
            $btn.hasClass("btn") || ($btn = $btn.closest(".btn")), Plugin.call($btn, "toggle"), $(e.target).is('input[type="radio"]') || $(e.target).is('input[type="checkbox"]') || e.preventDefault()
        }).on("focus.bs.button.data-api blur.bs.button.data-api", '[data-toggle^="button"]', function (e) { $(e.target).closest(".btn").toggleClass("focus", /^focus(in)?$/.test(e.type)) })
    }(jQuery),
    function () {
        $.fn.ajaxify = function () {
            var $this, ajaxForms; return $this = $(this), ajaxForms = $this.find("form[data-remote=true]"), ajaxForms.length && ajaxForms.each(function () {
                return $(this).bind("ajax:beforeSend", function () {
                    return $(this).find(":submit").button("loading"),
                        $(this).find(".form-submit-info").text("")
                }).bind("ajax:success", function (evt, data) {
                    var response = $.parseJSON(data);
                    if (response?.status == 0) {
                        htmlObj = '-error-wrapper';
                    } else {
                        htmlObj = '-wrapper';

                        //send reachGoal to metrika
                        if ($this.find("form[data-reachGoal=true]")) {
                            counterId = ajaxForms.attr('data-reachGoal-id');
                            targetName = ajaxForms.attr('data-reachGoal-name')

                            if (counterId !== 'undefined' && targetName !== 'undefined') {
                                ym(counterId, 'reachGoal', targetName)
                            }
                        }
                    }
                    return $(this).find(":submit").button("reset"), $("#" + this.id + htmlObj).html(response?.message)
                }).bind("ajax:error", function (evt, data) {
                    return $(this).find(":submit").button("reset"), $("#" + this.id + "-error-wrapper").html(data)
                })
            }), $this
        }, $(document).ready(function () {
            return $(document.body).ajaxify()
        })
    }.call(this),
    function () { $(document).ready(function () { $(".countdown").length && $(".countdown").each(function () { var date; return date = new Date, date = new Date(date.getTime() + 1e3 * $(this).data("seconds")), $(this).countdown({ until: date }) }) }) }.call(this),
    function () { $(document).ready(function () { return WebFont.load({ classes: !0, events: !1, google: { families: ["Roboto:300,400,500,700,900:latin,cyrillic"] } }) }) }.call(this);

const posterElement = document.querySelector('#poster');
if (posterElement) {
    const dataPosterElements = document.querySelectorAll('[data-bs-target="#bookModal"]');
    dataPosterElements.forEach(element => {
        element.addEventListener('click', () => {
            const poster = element.dataset.poster;
            posterElement.innerHTML = '';

            if (poster) {
                const img = document.createElement('img');
                img.src = poster;
                img.style.width = "100%";
                posterElement.append(img);
            }
        })
    });
}

