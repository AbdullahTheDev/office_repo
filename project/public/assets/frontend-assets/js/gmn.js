"use strict";
var t,
    $ = jQuery.noConflict();
function Slider(e, i) {
    return this.init(e, i);
}
function Sidebar(e) {
    return this.init(e);
}
function QuantityInput(e) {
    return this.init(e);
}
function Popup(e, i) {
    return this.init(e, i);
}
function ProductSingle(e) {
    return this.init(e);
}
function Calendar(e, i) {
    return this.init(e, i);
}
$.extend($.easing, {
    def: "easeOutQuad",
    swing: function (e, i, a, n, s) {
        return $.easing[$.easing.def](e, i, a, n, s);
    },
    easeOutQuad: function (e, i, a, n, s) {
        return -n * (i /= s) * (i - 2) + a;
    },
    easeOutQuint: function (e, i, a, n, s) {
        return n * ((i = i / s - 1) * i * i * i * i + 1) + a;
    },
}),
    (window.Wolmart = {}),
    (function (e) {
        var i, a, n, s, o, r, l;
        (Wolmart.$window = e(window)),
            (Wolmart.$body = e(document.body)),
            (Wolmart.status = ""),
            (Wolmart.isIE = navigator.userAgent.indexOf("Trident") >= 0),
            (Wolmart.isEdge = navigator.userAgent.indexOf("Edge") >= 0),
            (Wolmart.isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)),
            (Wolmart.call = function (e, i) {
                setTimeout(e, i);
            }),
            (Wolmart.parseOptions = function (e) {
                return "string" == typeof e ? JSON.parse(e.replace(/'/g, '"').replace(";", "")) : {};
            }),
            (Wolmart.parseTemplate = function (e, i) {
                return e.replace(/\{\{(\w+)\}\}/g, function () {
                    return i[arguments[1]];
                });
            }),
            (Wolmart.byId = function (e) {
                return document.getElementById(e);
            }),
            (Wolmart.byTag = function (e, i) {
                return i ? i.getElementsByTagName(e) : document.getElementsByTagName(e);
            }),
            (Wolmart.byClass = function (e, i) {
                return i ? i.getElementsByClassName(e) : document.getElementsByClassName(e);
            }),
            (Wolmart.setCookie = function (e, i, a) {
                var n = new Date();
                n.setTime(n.getTime() + 24 * a * 36e5), (document.cookie = e + "=" + i + ";expires=" + n.toUTCString() + ";path=/");
            }),
            (Wolmart.getCookie = function (e) {
                for (var i = e + "=", a = document.cookie.split(";"), n = 0; n < a.length; ++n) {
                    for (var s = a[n]; " " == s.charAt(0); ) s = s.substring(1);
                    if (0 == s.indexOf(i)) return s.substring(i.length, s.length);
                }
                return "";
            }),
            (Wolmart.$ = function (i) {
                return i instanceof jQuery ? i : e(i);
            }),
            (Wolmart.isOnScreen = function (e) {
                var i = window.pageXOffset,
                    a = window.pageYOffset,
                    n = e.getBoundingClientRect(),
                    s = n.left + i,
                    o = n.top + a;
                return o + n.height >= a && o <= a + window.innerHeight && s + n.width >= i && s <= i + window.innerWidth;
            }),
            (Wolmart.appear = function (i, a, n) {
                return (
                    n && Object.keys(n).length && e.extend(intersectionObserverOptions, n),
                    new IntersectionObserver(
                        function (i) {
                            for (var n = 0; n < i.length; n++) {
                                var s = i[n];
                                s.intersectionRatio > 0 && ("string" == typeof a ? Function("return " + functionName)() : a.call(e(s.target)));
                            }
                        },
                        { rootMargin: "0px 0px 200px 0px", threshold: 0, alwaysObserve: !0 }
                    ).observe(i),
                    this
                );
            }),
            (Wolmart.requestTimeout = function (e, i) {
                var a = window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame;
                if (!a) return setTimeout(e, i);
                var n,
                    s = {};
                return (
                    (s.val = a(function o(r) {
                        n || (n = r), r - n >= i ? e() : (s.val = a(o));
                    })),
                    s
                );
            }),
            (Wolmart.requestInterval = function (e, i, a) {
                var n = window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame;
                if (!n) return a ? setInterval(e, i) : setTimeout(e, a);
                var s,
                    o,
                    r = {};
                return (
                    (r.val = n(function l(c) {
                        s || (s = o = c), !a || c - s < a ? (c - o > i ? (e(), (r.val = n(l)), (o = c)) : (r.val = n(l))) : e();
                    })),
                    r
                );
            }),
            (Wolmart.deleteTimeout = function (e) {
                if (e) {
                    var i = window.cancelAnimationFrame || window.webkitCancelAnimationFrame || window.mozCancelAnimationFrame;
                    return i ? (e.val ? i(e.val) : void 0) : clearTimeout(e);
                }
            }),
            (Wolmart.setTab = function (i) {
                Wolmart.$body
                    .on("click", ".tab .nav-link", function (i) {
                        var a = e(this);
                        if ((i.preventDefault(), !a.hasClass("active"))) {
                            var n = e(a.attr("href"));
                            n.siblings(".active").removeClass("in active"), n.addClass("active in"), a.parent().parent().find(".active").removeClass("active"), a.addClass("active");
                        }
                    })
                    .on("click", ".link-to-tab", function (i) {
                        var a = e(i.currentTarget).attr("href"),
                            n = e(a),
                            s = n.parent().siblings(".nav");
                        i.preventDefault(),
                            n.siblings().removeClass("active in"),
                            n.addClass("active in"),
                            s.find(".nav-link").removeClass("active"),
                            s.find('[href="' + a + '"]').addClass("active"),
                            e("html").animate({ scrollTop: n.offset().top - 150 });
                    });
            }),
            (Wolmart.initCartAction = function (i) {
                Wolmart.$body
                    .on("click", i, function (i) {
                        e(".cart-dropdown").addClass("opened"), i.preventDefault();
                    })
                    .on("click", ".cart-offcanvas .cart-overlay", function (i) {
                        e(".cart-dropdown").removeClass("opened"), i.preventDefault();
                    })
                    .on("click", ".cart-offcanvas .cart-header, .cart-close", function (i) {
                        e(".cart-dropdown").removeClass("opened"), i.preventDefault();
                    });
            }),
            (Wolmart.initScrollTopButton = function () {
                var i = Wolmart.byId("scroll-top");
                i.addEventListener("click", function (i) {
                    e("html, body").animate({ scrollTop: 0 }, 600), i.preventDefault();
                });
                var a = function () {
                    window.pageYOffset > 400 ? i.classList.add("show") : i.classList.remove("show");
                };
                Wolmart.call(a, 500), window.addEventListener("scroll", a, { passive: !0 });
            }),
            (Wolmart.stickyDefaultOptions = { minWidth: 992, maxWidth: 2e4, top: !1, hide: !1, scrollMode: !0 }),
            (Wolmart.stickyToolboxOptions = { minWidth: 0, maxWidth: 767, top: !1, scrollMode: !0 }),
            (Wolmart.stickyProductOptions = { minWidth: 0, maxWidth: 2e4, scrollMode: !0, top: !1, hide: !1 }),
            (Wolmart.windowResized = function (e) {
                return e == Wolmart.resizeTimeStamp || ((Wolmart.resizeChanged = Wolmart.canvasWidth != window.innerWidth), (Wolmart.canvasWidth = window.innerWidth), (Wolmart.resizeTimeStamp = e)), Wolmart.resizeChanged;
            }),
            (Wolmart.stickyContent = (function () {
                function i(e, i) {
                    return this.init(e, i);
                }
                function a() {
                    Wolmart.$window.trigger("sticky_refresh.wolmart", { index: 0, offsetTop: 0 });
                }
                function n(e) {
                    (e && !Wolmart.windowResized(e.timeStamp)) || (Wolmart.$window.trigger("sticky_refresh_size.wolmart"), a());
                }
                return (
                    (i.prototype.init = function (i, a) {
                        (this.$el = i),
                            (this.options = e.extend(!0, {}, Wolmart.stickyDefaultOptions, a, Wolmart.parseOptions(i.attr("data-sticky-options")))),
                            Wolmart.$window.on("sticky_refresh.wolmart", this.refresh.bind(this)).on("sticky_refresh_size.wolmart", this.refreshSize.bind(this));
                    }),
                    (i.prototype.refreshSize = function (e) {
                        var i = window.innerWidth >= this.options.minWidth && window.innerWidth <= this.options.maxWidth;
                        (this.scrollPos = window.pageYOffset),
                            void 0 === this.top && (this.top = this.options.top),
                            window.innerWidth >= 768 && this.getTop
                                ? (this.top = this.getTop())
                                : this.options.top ||
                                  ((this.top = this.isWrap ? this.$el.parent().offset().top : this.$el.offset().top + this.$el[0].offsetHeight),
                                  this.$el.hasClass("has-dropdown") && (this.top += this.$el.find(".category-dropdown .dropdown-box")[0].offsetHeight)),
                            this.isWrap ? i || this.unwrap() : i && this.wrap(),
                            (Wolmart.sticky_top_height = 0),
                            e && setTimeout(this.refreshSize.bind(this), 50);
                    }),
                    (i.prototype.wrap = function () {
                        this.$el.wrap('<div class="sticky-content-wrapper"></div>'), (this.isWrap = !0);
                    }),
                    (i.prototype.unwrap = function () {
                        this.$el.unwrap(".sticky-content-wrapper"), (this.isWrap = !1);
                    }),
                    (i.prototype.refresh = function (i, a) {
                        var n = window.pageYOffset + a.offsetTop,
                            s = this.$el;
                        this.refreshSize(),
                            n > this.top && this.isWrap
                                ? ((this.height = s[0].offsetHeight),
                                  s.hasClass("fixed") || s.parent().css("height", this.height + "px"),
                                  s.hasClass("fix-top")
                                      ? (s.css("margin-top", a.offsetTop + "px"), (this.zIndex = this.options.max_index - a.index))
                                      : s.hasClass("fix-bottom")
                                      ? (s.css("margin-bottom", a.offsetBottom + "px"), (this.zIndex = this.options.max_index - a.index))
                                      : s.css({ transition: "opacity .5s", "z-index": this.zIndex }),
                                  this.options.scrollMode
                                      ? ((this.scrollPos >= n && s.hasClass("fix-top")) || (this.scrollPos <= n && s.hasClass("fix-bottom"))
                                            ? (s.addClass("fixed"), this.onFixed && this.onFixed(), s.hasClass("product-sticky-content") && e("body").addClass("addtocart-fixed"))
                                            : (s.removeClass("fixed").css("margin-top", "").css("margin-bottom", ""), this.onUnfixed && this.onUnfixed(), s.hasClass("product-sticky-content") && Wolmart.$body.removeClass("addtocart-fixed")),
                                        (this.scrollPos = n))
                                      : (s.addClass("fixed"), this.onFixed && this.onFixed()),
                                  s.is(".fixed.fix-top") ? ((a.offsetTop += s[0].offsetHeight), (Wolmart.sticky_top_height = a.offsetTop)) : s.is(".fixed.fix-bottom") && (a.offsetBottom += s[0].offsetHeight))
                                : (s.parent().css("height", ""),
                                  s.removeClass("fixed").css({ "margin-top": "", "margin-bottom": "", "z-index": "" }),
                                  this.onUnfixed && this.onUnfixed(),
                                  s.hasClass("product-sticky-content") && Wolmart.$body.removeClass("addtocart-fixed"));
                    }),
                    Wolmart.$window.on("wolmart_complete", function () {
                        window.addEventListener("scroll", a, { passive: !0 }),
                            Wolmart.$window.on("resize", n),
                            setTimeout(function () {
                                n();
                            }, 300);
                    }),
                    function (a, n) {
                        Wolmart.$(a).each(function () {
                            var a = e(this);
                            a.data("sticky-content") || a.data("sticky-content", new i(a, n));
                        });
                    }
                );
            })()),
            (Wolmart.parallax = function (i, a) {
                e.fn.themePluginParallax &&
                    Wolmart.$(i).each(function () {
                        var i = e(this);
                        i.themePluginParallax(e.extend(!0, Wolmart.parseOptions(i.attr("data-parallax-options")), a));
                    });
            }),
            (Wolmart.skrollrParallax = function () {
                Wolmart.isMobile || ("undefined" != typeof skrollr && Wolmart.$(".skrollable").length && skrollr.init({ forceHeight: !1 }));
            }),
            (Wolmart.initFloatingParallax = function () {
                e.fn.parallax &&
                    Wolmart.$(".floating-item").each(function (i) {
                        var a = e(this);
                        a.data("parallax") && (a.parallax("disable"), a.removeData("parallax"), a.removeData("options")), a.children().addClass("layer").attr("data-depth", a.attr("data-child-depth")), a.parallax(a.data("options"));
                    });
            }),
            (Wolmart.isotopeOptions = { itemsSelector: ".grid-item", layoutMode: "masonry", percentPosition: !0, masonry: { columnWidth: ".grid-space" } }),
            (Wolmart.isotopes = function (i, a) {
                if ("function" == typeof imagesLoaded && e.fn.isotope) {
                    var n = this;
                    Wolmart.$(i).each(function () {
                        var i = e(this),
                            s = e.extend(!0, {}, n.isotopeOptions, Wolmart.parseOptions(i.attr("data-grid-options")), a || {});
                        Wolmart.lazyLoad(i),
                            i.imagesLoaded(function () {
                                s.customInitHeight && i.height(i.height()),
                                    s.customDelay &&
                                        Wolmart.call(function () {
                                            i.isotope(s);
                                        }, parseInt(s.customDelay)),
                                    i.isotope(s);
                            });
                    });
                }
            }),
            (Wolmart.initNavFilter = function (i) {
                e.fn.isotope &&
                    Wolmart.$(i).on("click", function (i) {
                        var a = e(this),
                            n = a.attr("data-filter");
                        e(a.parent().parent().attr("data-target") || ".grid")
                            .isotope({ filter: n })
                            .isotope("on", "arrangeComplete", function () {
                                Wolmart.$window.trigger("appear.check");
                            }),
                            a.parent().siblings().children().removeClass("active"),
                            a.addClass("active"),
                            i.preventDefault();
                    });
            }),
            (Wolmart.ratingTooltip = function (e) {
                for (
                    var i = Wolmart.byClass("ratings-full", e || document.body),
                        a = i.length,
                        n = function () {
                            var e = parseInt(this.firstElementChild.style.width.slice(0, -1)) / 20;
                            this.lastElementChild.innerText = e ? e.toFixed(2) : e;
                        },
                        s = 0;
                    s < a;
                    ++s
                )
                    i[s].addEventListener("mouseover", n), i[s].addEventListener("touchstart", n, { passive: !0 });
            }),
            (Wolmart.setProgressBar = function (i) {
                Wolmart.$(i).each(function () {
                    var i = e(this),
                        a = i.parent().find("mark")[0].innerHTML,
                        n = "";
                    -1 != a.indexOf("%") ? (n = a) : -1 != a.indexOf("/") && (n = (n = (parseInt(a.split("/")[0]) / parseInt(a.split("/")[1])) * 100).toFixed(2).toString() + "%"), i.find("span").css("width", n);
                });
            }),
            (Wolmart.alert = function (i) {
                Wolmart.$body.on("click", i + " .btn-close", function (a) {
                    a.preventDefault(),
                        e(this)
                            .closest(i)
                            .fadeOut(function () {
                                e(this).remove();
                            });
                });
            }),
            (Wolmart.accordion = function (i) {
                Wolmart.$body.on("click", i, function (i) {
                    var n = e(this),
                        s = n.closest(".card").find(n.attr("href")),
                        o = n.closest(".accordion");
                    i.preventDefault(),
                        0 === o.find(".collapsing").length &&
                            0 === o.find(".expanding").length &&
                            (s.hasClass("expanded")
                                ? o.hasClass("radio-type") || a(s)
                                : s.hasClass("collapsed") &&
                                  (o.find(".expanded").length > 0
                                      ? Wolmart.isIE
                                          ? a(o.find(".expanded"), function () {
                                                a(s);
                                            })
                                          : (a(o.find(".expanded")), a(s))
                                      : a(s)));
                });
                var a = function (e, a) {
                    var n = e.closest(".card").find(i);
                    e.hasClass("expanded")
                        ? (n.removeClass("collapse").addClass("expand"),
                          e.addClass("collapsing").slideUp(300, function () {
                              e.removeClass("expanded collapsing").addClass("collapsed"), a && a();
                          }))
                        : e.hasClass("collapsed") &&
                          (n.removeClass("expand").addClass("collapse"),
                          e.addClass("expanding").slideDown(300, function () {
                              e.removeClass("collapsed expanding").addClass("expanded"), a && a();
                          }));
                };
            }),
            (Wolmart.animationOptions = { name: "fadeIn", duration: "1.2s", delay: ".2s" }),
            (Wolmart.appearAnimate = function (i) {
                Wolmart.$(i).each(function () {
                    var i = this;
                    Wolmart.appear(i, function () {
                        if (i.classList.contains("appear-animate")) {
                            var a = e.extend({}, Wolmart.animationOptions, Wolmart.parseOptions(i.getAttribute("data-animation-options")));
                            setTimeout(
                                function () {
                                    (i.style["animation-duration"] = a.duration), i.classList.add(a.name), i.classList.add("appear-animation-visible");
                                },
                                a.delay ? 1e3 * Number(a.delay.slice(0, -1)) : 0
                            );
                        }
                    });
                });
            }),
            (Wolmart.countDown = function (i) {
                e.fn.countdown &&
                    Wolmart.$(i).each(function () {
                        var i = e(this),
                            a = i.data("until"),
                            n = i.data("compact"),
                            s = i.data("format") ? i.data("format") : "DHMS",
                            o = i.data("labels-short") ? ["Years", "Months", "Weeks", "Days", "Hours", "Mins", "Secs"] : ["Years", "Months", "Weeks", "Days", "Hours", "Minutes", "Seconds"],
                            r = i.data("labels-short") ? ["Year", "Month", "Week", "Day", "Hour", "Min", "Sec"] : ["Year", "Month", "Week", "Day", "Hour", "Minute", "Second"];
                        if (i.data("relative")) c = a;
                        else
                            var l = a.split(", "),
                                c = new Date(l[0], l[1] - 1, l[2]);
                        i.countdown({ until: c, format: s, padZeroes: !0, compact: n, compactLabels: [" y", " m", " w", " days, "], timeSeparator: " : ", labels: o, labels1: r });
                    });
            }),
            (Wolmart.priceSlider = function (i, a) {
                "object" == typeof noUiSlider &&
                    Wolmart.$(i).each(function () {
                        var i = this;
                        noUiSlider.create(i, e.extend(!0, { start: [0, 400], connect: !0, step: 1, range: { min: 0, max: 635 } }, a)),
                            i.noUiSlider.on("update", function (a, n) {
                                (a = a.map(function (e) {
                                    return "$" + parseInt(e);
                                })),
                                    e(i).parent().find(".filter-price-range").text(a.join(" - "));
                            });
                    });
            }),
            (Wolmart.stickySidebarOptions = { autoInit: !0, minWidth: 991, containerSelector: ".sticky-sidebar-wrapper", autoFit: !0, activeClass: "sticky-sidebar-fixed", top: 0, bottom: 0 }),
            (Wolmart.stickySidebar = function (i) {
                if (e.fn.themeSticky) {
                    var a = 0;
                    function n() {
                        Wolmart.$(i).trigger("recalc.pin"), e(window).trigger("appear.check");
                    }
                    !e(".sticky-sidebar > .filter-actions").length &&
                        e(window).width() >= 992 &&
                        e(".sticky-content.fix-top").each(function (i) {
                            if (!e(this).hasClass("sticky-toolbox")) {
                                var n = e(this).hasClass("fixed");
                                (a += e(this).addClass("fixed").outerHeight()), n || e(this).removeClass("fixed");
                            }
                        }),
                        Wolmart.$(i).each(function () {
                            var i = e(this);
                            i.themeSticky(e.extend({}, Wolmart.stickySidebarOptions, { padding: { top: a } }, Wolmart.parseOptions(i.attr("data-sticky-options"))));
                        }),
                        setTimeout(n, 300),
                        Wolmart.$window.on("click", ".tab .nav-link", function () {
                            setTimeout(n);
                        });
                }
            }),
            (Wolmart.zoomImageOptions = { responsive: !0, borderSize: 0, zoomType: "inner", onZoomIn: !0, magnify: 1.1 }),
            (Wolmart.zoomImageObjects = []),
            (Wolmart.zoomImage = function (i) {
                e.fn.zoom &&
                    i &&
                    ("string" == typeof i ? e(i) : i).find("img").each(function () {
                        var i = e(this);
                        (Wolmart.zoomImageOptions.target = i.parent()), (Wolmart.zoomImageOptions.url = i.attr("data-zoom-image")), i.zoom(Wolmart.zoomImageOptions), Wolmart.zoomImageObjects.push(i);
                    });
            }),
            (Wolmart.zoomImageOnResize = function () {
                Wolmart.zoomImageObjects.forEach(function (i) {
                    i.each(function () {
                        var i = e(this).data("zoom");
                        i && i.refresh();
                    });
                });
            }),
            (Wolmart.lazyLoad = function (e, i) {
                function a() {
                    this.setAttribute("src", this.getAttribute("data-src")),
                        this.addEventListener("load", function () {
                            (this.style["padding-top"] = ""), this.classList.remove("lazy-img");
                        });
                }
                Wolmart.$(e)
                    .find(".lazy-img")
                    .each(function () {
                        void 0 !== i && i ? a.call(this) : Wolmart.appear(this, a);
                    });
            }),
            (Wolmart.initNotificationAlert = function () {
                Wolmart.$body.hasClass("has-notification") &&
                    setTimeout(function () {
                        Wolmart.$body.addClass("show-notification");
                    }, 5e3);
            }),
            (Wolmart.countTo = function (i) {
                e.fn.countTo &&
                    Wolmart.$(i).each(function () {
                        Wolmart.appear(this, function () {
                            var i = e(this);
                            setTimeout(function () {
                                i.countTo({
                                    onComplete: function () {
                                        i.addClass("complete");
                                    },
                                });
                            }, 300);
                        });
                    });
            }),
            (Wolmart.minipopupOption = {
                productClass: "",
                imageSrc: "",
                imageLink: "#",
                name: "",
                nameLink: "#",
                message: "",
                actionTemplate: "",
                isPurchased: !1,
                delay: 4e3,
                space: 20,
                template:
                    '<div class="minipopup-box"><div class="product product-list-sm {{productClass}}"><div class="product-details"><h4 class="product-name"><a href="{{nameLink}}">{{name}}</a></h4>{{message}}</div></div><div class="product-action">{{actionTemplate}}</div></div>',
            }),
            (Wolmart.Minipopup =
                ((a = 0),
                (n = []),
                (s = !1),
                (o = []),
                (r = !1),
                (l = function () {
                    if (!s) for (var e = 0; e < o.length; ++e) (o[e] -= 200) <= 0 && this.close(e--);
                }),
                {
                    init: function () {
                        var a = document.createElement("div");
                        (a.className = "minipopup-area"), Wolmart.byClass("page-wrapper")[0].appendChild(a), (i = e(a)), (this.close = this.close.bind(this)), (l = l.bind(this));
                    },
                    open: function (s, c) {
                        var d,
                            u = this,
                            p = e.extend(!0, {}, Wolmart.minipopupOption, s);
                        (d = e(Wolmart.parseTemplate(p.template, p))), (u.space = p.space);
                        var h = d.appendTo(i).css("top", -a).find("img");
                        h.length &&
                            h.on("load", function () {
                                (a += d[0].offsetHeight + u.space),
                                    d.addClass("show"),
                                    d.offset().top - window.pageYOffset < 0 && (u.close(), d.css("top", -a + d[0].offsetHeight + u.space)),
                                    d
                                        .on("mouseenter", function () {
                                            u.pause();
                                        })
                                        .on("mouseleave", function () {
                                            u.resume();
                                        })
                                        .on("touchstart", function (e) {
                                            u.pause(), e.stopPropagation();
                                        })
                                        .on("mousedown", function () {
                                            e(this).addClass("focus");
                                        })
                                        .on("mouseup", function () {
                                            u.close(e(this).index());
                                        }),
                                    Wolmart.$body.on("touchstart", function () {
                                        u.resume();
                                    }),
                                    n.push(d),
                                    o.length || (r = setInterval(l, 200)),
                                    o.push(p.delay),
                                    c && c(d);
                            });
                    },
                    close: function (e) {
                        var i = void 0 === e ? 0 : e,
                            s = n.splice(i, 1)[0];
                        o.splice(i, 1)[0];
                        var l = s[0].offsetHeight;
                        (a -= l + this.space),
                            s.removeClass("show"),
                            setTimeout(function () {
                                s.remove();
                            }, 300),
                            n.forEach(function (e, a) {
                                a >= i && e.hasClass("show") && e.stop(!0, !0).animate({ top: parseInt(e.css("top")) + l + 20 }, 600, "easeOutQuint");
                            }),
                            n.length || clearTimeout(r);
                    },
                    pause: function () {
                        s = !0;
                    },
                    resume: function () {
                        s = !1;
                    },
                })),
            (Wolmart.headerToggleSearch = function (i) {
                var a = Wolmart.$(i);
                a
                    .find(".form-control")
                    .on("focusin", function (e) {
                        a.addClass("show");
                    })
                    .on("focusout", function (e) {
                        a.removeClass("show");
                    }),
                    Wolmart.$body.on("click", ".sticky-footer .search-toggle", function (i) {
                        e(this).parent().toggleClass("show"), i.preventDefault();
                    });
            }),
            (Wolmart.scrollTo = function (i, a) {
                if ("number" == typeof i) s = i;
                else {
                    var n = Wolmart.$(i);
                    if (!n.length || "none" == n.css("display")) return;
                    var s = n.offset().top,
                        o = e("#wp-toolbar");
                    window.innerWidth > 600 && o.length && (s -= o.parent().outerHeight()),
                        e(".sticky-content.fix-top.fixed").each(function () {
                            s -= this.offsetHeight;
                        });
                }
                e("html,body")
                    .stop()
                    .animate({ scrollTop: s }, void 0 === a ? 0 : a);
            });
    })(jQuery),
    (function (e) {
        var i = function (i) {
                i.preventDefault(), e("body").addClass("mmenu-active");
            },
            a = function (e) {
                e.preventDefault(), Wolmart.$body.removeClass("mmenu-active");
            };
        Wolmart.menu = {
            init: function () {
                this.initMenu(), this.initCategoryMenu(), this.initMobileMenu(), this.initFilterMenu(), this.initCollapsibleWidget();
            },
            initMenu: function () {
                e(".menu li").each(function () {
                    !this.lastElementChild ||
                        ("UL" !== this.lastElementChild.tagName && !this.lastElementChild.classList.contains("megamenu")) ||
                        e(this).parent().hasClass("megamenu") ||
                        (this.classList.add("has-submenu"), this.lastElementChild.classList.contains("megamenu") || this.lastElementChild.classList.add("submenu"));
                }),
                    Wolmart.$window.on("resize", function () {
                        e(".main-nav megamenu").each(function () {
                            var i = e(this),
                                a = i.offset().left,
                                n = a + i.outerWidth() - (window.innerWidth - 20);
                            n > 0 && a > 20 && i.css("margin-left", -n);
                        });
                    });
            },
            initCategoryMenu: function () {
                var i = e(".category-dropdown");
                if (i.length) {
                    var a = i.find(".dropdown-box");
                    if (a.length) {
                        var n = e(".main").offset().top + a[0].offsetHeight;
                        (window.pageYOffset <= n || window.innerWidth < 992) && i.removeClass("show"),
                            window.addEventListener(
                                "scroll",
                                function () {
                                    window.pageYOffset <= n && window.innerWidth >= 992 && i.removeClass("show");
                                },
                                { passive: !0 }
                            ),
                            e(".category-toggle").on("click", function (e) {
                                e.preventDefault();
                            }),
                            i.on("mouseover", function (e) {
                                i.hasClass("menu-fixed") && window.pageYOffset > n && window.innerWidth >= 992 ? i.addClass("show") : !i.hasClass("menu-fixed") && window.innerWidth >= 992 && i.addClass("show");
                            }),
                            i.on("mouseleave", function (e) {
                                i.hasClass("menu-fixed") && window.pageYOffset > n && window.innerWidth >= 992 ? i.removeClass("show") : !i.hasClass("menu-fixed") && window.innerWidth >= 992 && i.removeClass("show");
                            });
                    }
                    if (i.hasClass("with-sidebar")) {
                        var s = Wolmart.byClass("sidebar");
                        s.length &&
                            (i.find(".dropdown-box").css("width", s[0].offsetWidth - 20),
                            Wolmart.$window.on("resize", function () {
                                i.find(".dropdown-box").css("width", s[0].offsetWidth - 20);
                            }));
                    }
                }
            },
            initMobileMenu: function () {
                e(".mobile-menu li, .toggle-menu li").each(function () {
                    if (this.lastElementChild && ("UL" === this.lastElementChild.tagName || this.lastElementChild.classList.contains("megamenu"))) {
                        var e = document.createElement("span");
                        (e.className = "toggle-btn"), this.firstElementChild.appendChild(e);
                    }
                }),
                    e(".mobile-menu-toggle").on("click", i),
                    e(".mobile-menu-overlay").on("click", a),
                    e(".mobile-menu-close").on("click", a),
                    Wolmart.$window.on("resize", a);
            },
            initFilterMenu: function () {
                e(".search-ul li").each(function () {
                    if (this.lastElementChild && "UL" === this.lastElementChild.tagName) {
                        var e = document.createElement("i");
                        (e.className = "la la-angle-down"), this.classList.add("with-ul"), this.firstElementChild.appendChild(e);
                    }
                }),
                    e(".with-ul > a i, .toggle-btn").on("click", function (i) {
                        e(this).parent().next().slideToggle(300).parent().toggleClass("show"), i.preventDefault();
                    });
            },
            initCollapsibleWidget: function () {
                e(".widget-collapsible .widget-title").each(function () {
                    var e = document.createElement("span");
                    (e.className = "toggle-btn"), this.appendChild(e);
                }),
                    e(".widget-collapsible .widget-title").on("click", function (i) {
                        var a = e(this),
                            n = a.siblings(".widget-body");
                        a.hasClass("collapsed") || n.css("display", "block"),
                            n.stop().slideToggle(300),
                            a.toggleClass("collapsed"),
                            setTimeout(function () {
                                e(".sticky-sidebar").trigger("recalc.pin");
                            }, 300);
                    });
            },
        };
    })(jQuery),
    (function (e) {
        var i = function (e) {
                var i = this.getAttribute("class");
                if ((i.match(/row|gutter\-\w\w|cols\-\d|cols\-\w\w-\d/g) && this.setAttribute("class", i.replace(/row|gutter\-\w\w|cols\-\d|cols\-\w\w-\d/g, "").replace(/\s+/, " ")), this.classList.contains("animation-slider")))
                    for (var a = this.children, n = a.length, s = 0; s < n; ++s) a[s].setAttribute("data-index", s + 1);
            },
            a = function (e) {
                var i,
                    a = this.firstElementChild.firstElementChild.children,
                    n = a.length;
                for (i = 0; i < n; ++i)
                    if (!a[i].classList.contains("active")) {
                        var s,
                            o = Wolmart.byClass("appear-animate", a[i]);
                        for (s = o.length - 1; s >= 0; --s) o[s].classList.remove("appear-animate");
                    }
            },
            n = function (i) {
                e(window).trigger("appear.check");
                var a = e(i.currentTarget),
                    n = a.find(".owl-item.active video");
                a.find(".owl-item:not(.active) video").each(function () {
                    this.paused || a.trigger("play.owl.autoplay"), this.pause(), (this.currentTime = 0);
                }),
                    n.length &&
                        (!0 === a.data("owl.carousel").options.autoplay && a.trigger("stop.owl.autoplay"),
                        n.each(function () {
                            this.paused && this.play();
                        }));
            },
            s = function (i) {
                var a = this;
                e(i.currentTarget)
                    .find(".owl-item.active .slide-animate")
                    .each(function () {
                        var i = e(this),
                            n = e.extend(!0, {}, Wolmart.animationOptions, Wolmart.parseOptions(i.data("animation-options"))),
                            s = n.duration,
                            o = n.delay,
                            r = n.name;
                        setTimeout(function () {
                            if ((i.css("animation-duration", s), i.css("animation-delay", o), i.addClass(r), i.hasClass("maskLeft"))) {
                                i.css("width", "fit-content");
                                var e = i.width();
                                i.css("width", 0).css("transition", "width " + (s || "0.75s") + " linear " + (o || "0s")), i.css("width", e);
                            }
                            s = s || "0.75s";
                            var n = Wolmart.requestTimeout(
                                function () {
                                    i.addClass("show-content");
                                },
                                o ? 1e3 * Number(o.slice(0, -1)) + 200 : 200
                            );
                            a.timers.push(n);
                        }, 300);
                    });
            },
            o = function (i) {
                e(i.currentTarget)
                    .find(".owl-item.active .slide-animate")
                    .each(function () {
                        var i = e(this);
                        i.addClass("show-content"), i.attr("style", "");
                    });
            },
            r = function (i) {
                var a = e(i.currentTarget);
                (this.translateFlag = 1),
                    (this.prev = this.next),
                    a.find(".owl-item .slide-animate").each(function () {
                        var i = e(this),
                            a = e.extend(!0, {}, Wolmart.animationOptions, Wolmart.parseOptions(i.data("animation-options")));
                        i.removeClass(a.name);
                    });
            },
            l = function (i) {
                var a = this,
                    n = e(i.currentTarget);
                if (1 == a.translateFlag) {
                    if (((a.next = n.find(".owl-item").eq(i.item.index).children().attr("data-index")), n.find(".show-content").removeClass("show-content"), a.prev != a.next)) {
                        if ((n.find(".show-content").removeClass("show-content"), n.hasClass("animation-slider"))) {
                            for (var s = 0; s < a.timers.length; s++) Wolmart.deleteTimeout(a.timers[s]);
                            a.timers = [];
                        }
                        n.find(".owl-item.active .slide-animate").each(function () {
                            var i = e(this),
                                n = e.extend(!0, {}, Wolmart.animationOptions, Wolmart.parseOptions(i.data("animation-options"))),
                                s = n.duration,
                                o = n.delay,
                                r = n.name;
                            i.css("animation-duration", s),
                                i.css("animation-delay", o),
                                i.css("transition-property", "visibility, opacity"),
                                i.css("transition-delay", o),
                                i.css("transition-duration", s),
                                i.addClass(r),
                                (s = s || "0.75s"),
                                i.addClass("show-content");
                            var l = Wolmart.requestTimeout(
                                function () {
                                    i.css("transition-property", ""), i.css("transition-delay", ""), i.css("transition-duration", ""), a.timers.splice(a.timers.indexOf(l), 1);
                                },
                                o ? 1e3 * Number(o.slice(0, -1)) + 500 * Number(s.slice(0, -1)) : 500 * Number(s.slice(0, -1))
                            );
                            a.timers.push(l);
                        });
                    } else n.find(".owl-item").eq(i.item.index).find(".slide-animate").addClass("show-content");
                    a.translateFlag = 0;
                }
            };
        (Slider.defaults = {
            responsiveClass: !0,
            navText: ['<i class="w-icon-angle-left">', '<i class="w-icon-angle-right">'],
            checkVisible: !1,
            items: 1,
            smartSpeed: navigator.userAgent.indexOf("Edge") > -1 ? 200 : 700,
            autoplaySpeed: navigator.userAgent.indexOf("Edge") > -1 ? 200 : 1e3,
            autoplayTimeout: 1e4,
        }),
            (Slider.zoomImage = function () {
                Wolmart.zoomImage(this.$element);
            }),
            (Slider.zoomImageRefresh = function () {
                this.$element.find("img").each(function () {
                    var i = e(this);
                    if (e.fn.zoom) {
                        var a = i.data("zoom");
                        void 0 !== a ? a.refresh() : ((Wolmart.zoomImageOptions.zoomContainer = i.parent()), i.zoom(Wolmart.zoomImageOptions));
                    }
                });
            }),
            (Slider.presets = {
                "intro-slider": { animateIn: "fadeIn", animateOut: "fadeOut" },
                "product-single-carousel": { dots: !1, nav: !0, onInitialize: Slider.zoomImage, onRefreshed: Slider.zoomImageRefresh },
                "product-gallery-carousel": { dots: !1, nav: !0, margin: 30, items: 1, responsive: { 576: { items: 2 } }, onInitialized: Slider.zoomImage, onRefreshed: Slider.zoomImageRefresh },
            }),
            (Slider.prototype.init = function (c, d) {
                (this.timers = []), (this.translateFlag = 0), (this.prev = 1), (this.next = 1), Wolmart.lazyLoad(c, !0);
                var u = c.attr("class").split(" "),
                    p = e.extend(!0, {}, Slider.presets, Slider.defaults);
                if (
                    (u.forEach(function (i) {
                        var a = Slider.presets[i];
                        a && e.extend(!0, p, a);
                    }),
                    c.find("video").each(function () {
                        this.loop = !1;
                    }),
                    e.extend(!0, p, Wolmart.parseOptions(c.attr("data-owl-options")), d),
                    (s = s.bind(this)),
                    (r = r.bind(this)),
                    (l = l.bind(this)),
                    c.on("initialize.owl.carousel", i).on("initialized.owl.carousel", a).on("translated.owl.carousel", n),
                    c.hasClass("animation-slider") && c.on("initialized.owl.carousel", s).on("resized.owl.carousel", o).on("translate.owl.carousel", r).on("translated.owl.carousel", l),
                    c.owlCarousel(p),
                    p.dotsContainer)
                ) {
                    var h = e(p.dotsContainer);
                    h.find("a").on("click", function (i) {
                        i.preventDefault();
                        var a = e(this);
                        if (!a.hasClass("active")) {
                            var n = a.index();
                            h.parent().find(".owl-carousel").trigger("to.owl.carousel", [n]), a.addClass("active").siblings().removeClass("active");
                        }
                    });
                }
            }),
            (Wolmart.slider = function (i, a) {
                Wolmart.$(i).each(function () {
                    var i = e(this);
                    Wolmart.call(function () {
                        new Slider(i, a);
                    });
                });
            });
    })(jQuery),
    (function (e) {
        var i = function () {
            window.innerWidth < 992 &&
                (this.$sidebar.find(".sidebar-content").removeAttr("style"), this.$sidebar.find(".sidebar-content").attr("style", ""), this.$sidebar.find(".toolbox").children(":not(:first-child)").removeAttr("style"));
        };
        (Sidebar.prototype.init = function (a) {
            var n = this;
            return (
                (n.name = a),
                (n.$sidebar = e("." + a)),
                (n.isNavigation = !1),
                n.$sidebar.length &&
                    ((n.isNavigation = n.$sidebar.hasClass("sidebar-fixed") && n.$sidebar.parent().hasClass("toolbox-wrap")),
                    n.isNavigation && ((i = i.bind(this)), Wolmart.$window.on("resize", i)),
                    Wolmart.$window.on("resize", function () {
                        Wolmart.$body.removeClass(a + "-active");
                    }),
                    n.$sidebar
                        .find(".sidebar-toggle, .sidebar-toggle-btn")
                        .add("sidebar" === a ? ".left-sidebar-toggle" : "." + a + "-toggle")
                        .on("click", function (i) {
                            n.toggle(), e(this).blur(), i.preventDefault();
                        }),
                    n.$sidebar.find(".sidebar-overlay, .sidebar-close").on("click", function (e) {
                        Wolmart.$body.removeClass(a + "-active"), e.preventDefault();
                    })),
                !1
            );
        }),
            (Sidebar.prototype.toggle = function () {
                var i = this;
                if (window.innerWidth >= 992 && i.$sidebar.hasClass("sidebar-fixed")) {
                    var a = i.$sidebar.hasClass("closed");
                    if (
                        (i.isNavigation &&
                            (a || i.$sidebar.find(".filter-clean").hide(),
                            i.$sidebar.siblings(".toolbox").children(":not(:first-child)").fadeToggle("fast"),
                            i.$sidebar
                                .find(".sidebar-content")
                                .stop()
                                .animate({ height: "toggle", "margin-bottom": a ? "toggle" : -6 }, function () {
                                    e(this).css("margin-bottom", ""), a && i.$sidebar.find(".filter-clean").fadeIn("fast");
                                })),
                        i.$sidebar.hasClass("shop-sidebar"))
                    ) {
                        var n = e(".main-content .product-wrapper");
                        n.length && n.hasClass("product-lists") && n.toggleClass("row cols-xl-2", !a);
                    }
                } else i.$sidebar.find(".sidebar-overlay .sidebar-close").css("margin-left", -(window.innerWidth - document.body.clientWidth)), Wolmart.$body.toggleClass(i.name + "-active").removeClass("closed");
                setTimeout(function () {
                    e(window).trigger("appear.check");
                }, 400);
            }),
            (Wolmart.sidebar = function (e) {
                return new Sidebar().init(e);
            });
    })(jQuery),
    (function (e) {
        Wolmart.shop = {
            init: function () {
                $("#stock").val();
                var i,
                    a = "",
                    n = "",
                    s = "";
                Wolmart.call(Wolmart.ratingTooltip, 500),
                    Wolmart.call(Wolmart.setProgressBar(".progress-bar"), 500),
                    this.initProductType("slideup"),
                    this.initVariation(),
                    this.initProductsScrollLoad(".scroll-load"),
                    Wolmart.$body.on("mousedown", ".select-menu", function (i) {
                        var a = e(i.currentTarget),
                            n = e(i.target),
                            s = a.hasClass("opened");
                        e(".select-menu").removeClass("opened"),
                            a.is(n.parent())
                                ? (s || a.addClass("opened"), i.stopPropagation())
                                : (n.parent().toggleClass("active"),
                                  n.parent().hasClass("active")
                                      ? (e(".selected-items").children().length < 2 && e(".selected-items").show(),
                                        e('<a href="#" class="selected-item">' + n.text().split("(")[0] + '<i class="la la-close"></i></a>')
                                            .insertBefore(".selected-items .filter-clean")
                                            .hide()
                                            .fadeIn()
                                            .data("link", n.parent()))
                                      : e(".selected-items > .selected-item")
                                            .filter(function (e, i) {
                                                return i.innerText == n.text().split("(")[0];
                                            })
                                            .fadeOut(function () {
                                                e(this).remove(), e(".selected-items").children().length < 2 && e(".selected-items").hide();
                                            }));
                    }),
                    e(".selected-items .filter-clean").on("click", function (i) {
                        var a = e(this);
                        a.siblings().each(function () {
                            var i = e(this).data("link");
                            i && i.removeClass("active");
                        }),
                            a.parent().fadeOut(function () {
                                a.siblings().remove();
                            }),
                            i.preventDefault();
                    }),
                    e(".filter-clean").on("click", function (i) {
                        e(".shop-sidebar .filter-items .active").removeClass("active"), i.preventDefault();
                    }),
                    Wolmart.$body.on("click", ".select-menu a", function (e) {
                        e.preventDefault();
                    }),
                    Wolmart.$body.on("click", ".selected-item i", function (i) {
                        e(i.currentTarget)
                            .parent()
                            .fadeOut(function () {
                                var i = e(this),
                                    a = i.data("link");
                                a && a.toggleClass("active"), i.remove(), e(".select-items").children().length < 2 && e(".select-items").hide();
                            }),
                            i.preventDefault();
                    }),
                    Wolmart.$body.on("mousedown", function (i) {
                        e(".select-menu").removeClass("opened");
                    }),
                    Wolmart.$body.on("click", ".filter-items a", function (i) {
                        var a = e(this).closest(".filter-items");
                        a.hasClass("search-ul") || a.parent().hasClass("select-menu") || (e(this).parent().toggleClass("active"), i.preventDefault());
                    }),
                    Wolmart.$body.on("click", ".product-action .btn-cart", function (i) {
                        i.preventDefault(),
                            $.get($(this).data("href"), function (e) {
                                "digital" == e
                                    ? toastr.error(langg.already_cart)
                                    : 0 == e
                                    ? toastr.error(langg.out_stock)
                                    : ($("#cart-count").html(e[0]),
                                      $("#cart-items").load(mainurl + "/carts/view"),
                                      toastr.success(langg.add_cart),
                                      $("#prev_url").val() == $("#base_url").val() + "/system_builder" && (location.href = $("#base_url").val() + "/system_builder"));
                            });
                        var a = e(this),
                            n = a.closest(".product, .product-popup");
                        a.toggleClass("added").addClass("load-more-overlay loading"),
                            setTimeout(function () {
                                a.removeClass("load-more-overlay loading"),
                                    Wolmart.Minipopup.open({
                                        productClass: " product-cart",
                                        name: n.find(".product-name, .product-title").text(),
                                        nameLink: n.find(".product-name > a, .product-title > a").attr("href"),
                                        imageSrc: n.find(".product-media img, .product-image:first-child img").attr("src"),
                                        imageLink: n.find(".product-name > a").attr("href"),
                                        message: "<p>has been added to cart:</p>",
                                        actionTemplate: '<a href="' + mainurl + '/carts" class="btn btn-rounded btn-sm">View Cart</a><a href="' + mainurl + '/checkout" class="btn btn-dark btn-rounded btn-sm">Checkout</a>',
                                    });
                            }, 500);
                    }),
                    Wolmart.$body.on("click", ".product-single .btn-cart", function (i) {
                        i.preventDefault();
                        var o = jQuery(".qttotal").val(),
                            r = jQuery("#product_id").val();
                        jQuery("#product_price").val(),
                            jQuery(".product-attr").length > 0 &&
                                ((n = jQuery(".product-attr:checked")
                                    .map(function () {
                                        return jQuery(this).val();
                                    })
                                    .get()),
                                (a = jQuery(".product-attr:checked")
                                    .map(function () {
                                        return jQuery(this).data("key");
                                    })
                                    .get()),
                                (s = $(".product-attr:checked")
                                    .map(function () {
                                        return $(this).data("price");
                                    })
                                    .get())),
                            jQuery.ajax({
                                type: "GET",
                                url: mainurl + "/addnumcart",
                                data: { id: r, qty: o, size: "", color: "", size_qty: "", size_price: "", size_key: "", keys: a, values: n, prices: s },
                                success: function (e) {
                                    console.log(e), "digital" == e || 0 == e || (jQuery(".cart-count").html(e[0]), jQuery("#cart-items").load(mainurl + "/carts/view"));
                                },
                            });
                        var l = e(this),
                            c = l.closest(".product, .product-popup");
                        l.toggleClass("added").addClass("load-more-overlay loading"),
                            setTimeout(function () {
                                l.removeClass("load-more-overlay loading"),
                                    Wolmart.Minipopup.open({
                                        productClass: " product-cart",
                                        name: c.find(".product-name, .product-title").text(),
                                        nameLink: c.find(".product-name > a, .product-title > a").attr("href"),
                                        imageSrc: c.find(".product-media img, .product-image:first-child img").attr("src"),
                                        imageLink: c.find(".product-name > a").attr("href"),
                                        message: "<p>has been added to cart:</p>",
                                        actionTemplate: '<a href="' + mainurl + '/carts" class="btn btn-rounded btn-sm">View Cart</a><a href="' + mainurl + '/checkout" class="btn btn-dark btn-rounded btn-sm">Checkout</a>',
                                    });
                            }, 500);
                    }),
                    Wolmart.$body.on("click", ".btn-wishlist", function (i) {
                        i.preventDefault();
                        var a = e(this);
                        $.get(a.data("href"), function (e) {
                            1 == e[0] ? (toastr.success(langg.add_wish), $("#wishlist-count").html(e[1])) : toastr.error(langg.already_wish);
                        }),
                            a.toggleClass("added").addClass("load-more-overlay loading"),
                            setTimeout(function () {
                                a.removeClass("load-more-overlay loading"), a.toggleClass("w-icon-heart").toggleClass("w-icon-heart-full");
                            }, 500);
                    }),
                    (i = e(".product-popup")).length &&
                        Wolmart.$body.on("click", ".btn-quickview", function (a) {
                            a.preventDefault(),
                                Wolmart.popup(
                                    {
                                        items: { src: i[0].outerHTML },
                                        callbacks: {
                                            open: function () {
                                                Wolmart.productSingle(e(".mfp-product .product-single")), Popup.defaults.callbacks.open();
                                            },
                                        },
                                    },
                                    "quickview"
                                );
                        }),
                    (function () {
                        var i,
                            a = [],
                            n = e(".page-wrapper > .compare-popup");
                        function s() {
                            n.find(".title").after('<p class="compare-count text-center text-light mb-0">(' + i + " Products)</p>"), n.find(".compare-count").length > 1 && n.find("p:last-child").remove();
                        }
                        n.length ||
                            document.body.classList.contains("docs") ||
                            (e(".page-wrapper").append(
                                '<div class="compare-popup">                    <div class="container">                        <div class="compare-title">                            <h4 class="title title-center">Compare Products</h4>                        </div>                        <ul class="compare-product-list list-style-none">                            <li></li><li></li><li></li><li></li>                        </ul>                        <a href="#" class="btn btn-clean">Clean All</a>                        <a href="compare.html" class="btn btn-dark btn-rounded">Start Compare !</a>                    </div>                </div>                <div class="compare-popup-overlay">                </div>'
                            ),
                            (n = e(".page-wrapper > .compare-popup"))),
                            Wolmart.$body
                                .on("click", ".product .btn-compare", function (o) {
                                    var r = e(this);
                                    r.hasClass("added") && returne(),
                                        o.preventDefault(),
                                        r.toggleClass("added").addClass("load-more-overlay loading"),
                                        setTimeout(function () {
                                            r.removeClass("load-more-overlay loading"), r.toggleClass("w-icon-compare").toggleClass("w-icon-check-solid"), r.attr("href", "compare.html"), n.addClass("show");
                                        }, 500);
                                    var l = r.closest(".product").find("img").eq(0).attr("src");
                                    a.length >= 4 && a.shift(),
                                        a.push(l),
                                        e(".compare-popup li").each(function (e) {
                                            a[e] &&
                                                (this.innerHTML =
                                                    '<a href="product-default.html"><figure><img src="' +
                                                    a[e] +
                                                    '"/></figure></a>                                        <a href="#" class="btn btn-remove"><i class="w-icon-times-solid"></i></a>');
                                        }),
                                        (i = a.length),
                                        s();
                                })
                                .on("click", ".compare-popup .btn-remove", function (n) {
                                    n.preventDefault();
                                    var o = e(n.currentTarget).closest("li"),
                                        r = o.index(),
                                        l = o.find("img").attr("src");
                                    l &&
                                        e(".page-wrapper .product img").each(function () {
                                            if (this.getAttribute("src") == l) {
                                                var i = e(this).closest(".product").find(".btn-compare");
                                                i.length && (i.removeClass("added").attr("href", "#"), i.toggleClass("w-icon-check-solid").toggleClass("w-icon-compare"));
                                            }
                                        }),
                                        a.splice(r, 1),
                                        3 == r && o.empty(),
                                        o
                                            .nextAll()
                                            .each(function () {
                                                e(this).prev().html(e(this).html());
                                            })
                                            .last()
                                            .empty(),
                                        (i = a.length),
                                        s();
                                })
                                .on("click", ".compare-popup .btn-clean", function (n) {
                                    n.preventDefault(),
                                        e(".page-wrapper .product img").each(function () {
                                            var i = e(this),
                                                n = this.getAttribute("src");
                                            a.forEach(function (e) {
                                                if (n == e) {
                                                    var a = i.closest(".product").find(".btn-compare");
                                                    a.length && (a.removeClass("added").attr("href", "#"), a.toggleClass("w-icon-check-solid").toggleClass("w-icon-compare"));
                                                }
                                            });
                                        }),
                                        a.splice(0, 4),
                                        (i = a.length),
                                        e(this).parent().find(".compare-product-list li").empty(),
                                        s();
                                }),
                            Wolmart.$body.on("click", ".compare-popup-overlay", function () {
                                n.removeClass("show");
                            });
                    })(),
                    Wolmart.priceSlider(".filter-price-slider");
            },
            initProductType: function (e) {},
            initVariation: function (i) {
                e(".product:not(.product-single) .product-variations > a").on("click", function (i) {
                    var a = e(this),
                        n = a.closest(".product").find(".product-media img");
                    n.data("image-src") || n.data("image-src", n.attr("src")),
                        a.toggleClass("active").siblings().removeClass("active"),
                        a.hasClass("active") ? n.attr("src", a.data("src")) : (n.attr("src", n.data("image-src")), a.blur()),
                        i.preventDefault();
                });
            },
            initProductsScrollLoad: function (i) {
                var a,
                    n = Wolmart.$(i),
                    s = e(i).data("url");
                s || (s = "assets/ajax/products.html");
                var o = function (i) {
                    window.pageYOffset > a + n.outerHeight() - window.innerHeight - 150 &&
                        "loading" != n.data("load-state") &&
                        e.ajax({
                            url: s,
                            success: function (i) {
                                var a = e(i);
                                n.data("load-state", "loading"),
                                    n.next().hasClass("load-more-overlay") ? n.next().addClass("loading") : e('<div class="mt-4 mb-4 load-more-overlay loading"></div>').insertAfter(n),
                                    setTimeout(function () {
                                        n.next().removeClass("loading"),
                                            n.append(a),
                                            setTimeout(function () {
                                                n.find(".product-wrap.fade:not(.in)").addClass("in");
                                            }, 200),
                                            n.data("load-state", "loaded"),
                                            Wolmart.countDown(a.find(".product-countdown"));
                                    }, 500);
                                var s = parseInt(n.data("load-count") ? n.data("load-count") : 0);
                                n.data("load-count", ++s), s > 2 && window.removeEventListener("scroll", o, { passive: !0 });
                            },
                            failure: function () {
                                $this.text("Sorry something went wrong.");
                            },
                        });
                };
                n.length > 0 && ((a = n.offset().top), window.addEventListener("scroll", o, { passive: !0 }));
            },
        };
    })(jQuery),
    (t = jQuery),
    (QuantityInput.min = 1),
    (QuantityInput.max = 1e6),
    (QuantityInput.value = 1),
    (QuantityInput.prototype.init = function (e) {
        var i = this;
        (i.$minus = !1),
            (i.$plus = !1),
            (i.$value = !1),
            (i.value = !1),
            (i.startIncrease = i.startIncrease.bind(i)),
            (i.startDecrease = i.startDecrease.bind(i)),
            (i.stop = i.stop.bind(i)),
            (i.min = parseInt(e.attr("min"))),
            (i.max = parseInt(e.attr("max"))),
            i.min || e.attr("min", (i.min = QuantityInput.min)),
            i.max || e.attr("max", (i.max = QuantityInput.max)),
            (i.$value = e.val((i.value = QuantityInput.value))),
            (i.$minus = e
                .parent()
                .find(".quantity-minus")
                .on("mousedown", function (e) {
                    e.preventDefault(), i.startDecrease();
                })
                .on("touchstart", function (e) {
                    e.cancelable && e.preventDefault(), i.startDecrease();
                })
                .on("mouseup", i.stop)),
            (i.$plus = e
                .parent()
                .find(".quantity-plus")
                .on("mousedown", function (e) {
                    e.preventDefault(), i.startIncrease();
                })
                .on("touchstart", function (e) {
                    e.cancelable && e.preventDefault(), i.startIncrease();
                })
                .on("mouseup", i.stop)),
            Wolmart.$body.on("mouseup", i.stop).on("touchend", i.stop).on("touchcancel", i.stop);
    }),
    (QuantityInput.prototype.startIncrease = function (e) {
        e && e.preventDefault();
        var i = this;
        (i.value = i.$value.val()),
            i.value < i.max && i.$value.val(++i.value),
            (i.increaseTimer = Wolmart.requestTimeout(function () {
                (i.speed = 1),
                    (i.increaseTimer = Wolmart.requestInterval(function () {
                        i.$value.val((i.value = Math.min(i.value + Math.floor((i.speed *= 1.05)), i.max)));
                    }, 50));
            }, 400));
    }),
    (QuantityInput.prototype.startDecrease = function (e) {
        e && e.preventDefault();
        var i = this;
        (i.value = i.$value.val()),
            i.value > i.min && i.$value.val(--i.value),
            (i.decreaseTimer = Wolmart.requestTimeout(function () {
                (i.speed = 1),
                    (i.decreaseTimer = Wolmart.requestInterval(function () {
                        i.$value.val((i.value = Math.max(i.value - Math.floor((i.speed *= 1.05)), i.min)));
                    }, 50));
            }, 400));
    }),
    (QuantityInput.prototype.stop = function (e) {
        Wolmart.deleteTimeout(this.increaseTimer), Wolmart.deleteTimeout(this.decreaseTimer);
    }),
    (Wolmart.initQtyInput = function (e) {
        Wolmart.$(e).each(function () {
            var e = t(this);
            e.data("quantityInput") || e.data("quantityInput", new QuantityInput(e));
        });
    }),
    (function (e) {
        (Popup.defaults = {
            removalDelay: 300,
            callbacks: {
                open: function () {
                    e("html").css("overflow-y", "hidden"), e("body").css("overflow-x", "visible"), e(".mfp-wrap").css("overflow", "hidden auto"), e(".sticky-header.fixed").css("padding-right", window.innerWidth - document.body.clientWidth);
                },
                close: function () {
                    e("html").css("overflow-y", ""), e("body").css("overflow-x", "hidden"), e(".mfp-wrap").css("overflow", ""), e(".sticky-header.fixed").css("padding-right", "");
                },
            },
        }),
            (Popup.presets = {
                quickview: { type: "inline", mainClass: "mfp-product mfp-fade", tLoading: "Loading..." },
                video: { type: "iframe", mainClass: "mfp-fade", preloader: !1, closeBtnInside: !1 },
                login: { type: "ajax", mainClass: "mfp-login-popup mfp-fade ", tLoading: "", preloader: !1 },
            }),
            (Popup.prototype.init = function (i, a) {
                var n = e.magnificPopup.instance;
                n.isOpen && n.content && !n.content.hasClass("login-popup")
                    ? (n.close(),
                      setTimeout(function () {
                          e.magnificPopup.open(e.extend(!0, {}, Popup.defaults, a ? Popup.presets[a] : {}, i));
                      }, 500))
                    : e.magnificPopup.open(e.extend(!0, {}, Popup.defaults, a ? Popup.presets[a] : {}, i));
            }),
            (Wolmart.popup = function (e, i) {
                return new Popup(e, i);
            });
    })(jQuery),
    (function (e) {
        var i = { margin: 0, items: 4, dots: !1, nav: !0, navText: ['<i class="fas fa-chevron-left"></i>', '<i class="fas fa-chevron-right"></i>'] },
            a = function (e) {
                var i = e.$thumbsWrap.offset().top + e.$thumbsWrap[0].offsetHeight,
                    a = e.$thumbs.offset().top + e.thumbsHeight;
                a >= i + e.$productThumb[0].offsetHeight
                    ? (e.$thumbs.css("top", parseInt(e.$thumbs.css("top")) - e.$productThumb[0].offsetHeight), e.$thumbUp.removeClass("disabled"))
                    : (a > i && (e.$thumbs.css("top", parseInt(e.$thumbs.css("top")) - Math.ceil(a - i)), e.$thumbUp.removeClass("disabled")), e.$thumbDown.addClass("disabled"));
            },
            n = function (e) {
                var i = e.$thumbsWrap.offset().top,
                    a = e.$thumbs.offset().top;
                a <= i - e.$productThumb[0].offsetHeight
                    ? (e.$thumbs.css("top", parseInt(e.$thumbs.css("top")) + e.$productThumb[0].offsetHeight), e.$thumbDown.removeClass("disabled"))
                    : (a < i && (e.$thumbs.css("top", parseInt(e.$thumbs.css("top")) - Math.ceil(a - i)), e.$thumbDown.removeClass("disabled")), e.$thumbUp.addClass("disabled"));
            },
            s = function (a) {
                a.thumbsIsVertical
                    ? (a.$thumbs.hasClass("owl-carousel") && (a.$thumbs.data("owl.carousel").destroy(), a.$thumbs.removeClass("owl-carousel")),
                      (a.thumbsHeight = a.$productThumb[0].offsetHeight * a.thumbsCount + parseInt(a.$productThumb.css("margin-bottom")) * (a.thumbsCount - 1)),
                      a.$thumbUp.addClass("disabled"),
                      a.$thumbDown.toggleClass("disabled", a.thumbsHeight <= a.$thumbsWrap[0].offsetHeight))
                    : (a.$thumbs.removeAttr("style"),
                      a.$thumbs.hasClass("owl-carousel") ||
                          a.$thumbs
                              .addClass("owl-carousel")
                              .attr(
                                  "class",
                                  a.$thumbs.attr("class") &&
                                      a.$thumbs
                                          .attr("class")
                                          .replace(/row|gutter\-\w\w|cols\-\d|cols\-\w\w-\d/g, "")
                                          .replace(/\s+/, " ")
                              )
                              .owlCarousel(e.extend(!0, a.isQuickView ? { onInitialized: o, onResized: o } : {}, i)));
            },
            o = function () {
                this.$wrapper.find(".product-details").css("height", window.innerWidth > 767 ? this.$wrapper.find(".product-gallery")[0].clientHeight : "");
            },
            r = function (i) {
                var a = e(this);
                a.hasClass("added") ||
                    (i.preventDefault(),
                    a.addClass("load-more-overlay loading"),
                    setTimeout(function () {
                        a.removeClass("load-more-overlay loading").toggleClass("w-icon-heart").toggleClass("w-icon-heart-full").addClass("added").attr("href", "wishlist.html");
                    }, 500));
            };
        (ProductSingle.prototype.init = function (i) {
            var l,
                c = this,
                d = i.find(".product-single-carousel");
            (c.$wrapper = i),
                (c.isQuickView = !!i.closest(".mfp-content").length),
                (c._isPgVertical = !1),
                c.isQuickView && ((o = o.bind(this)), Wolmart.ratingTooltip()),
                d
                    .on("initialized.owl.carousel", function (i) {
                        var o;
                        document.body.classList.contains("home") ||
                            (c.isQuickView || d.append('<a href="#" class="product-gallery-btn product-image-full"><i class="w-icon-zoom"></i></a>'),
                            d.parent().hasClass("product-gallery-video") &&
                                (c.isQuickView || d.append('<a href="#" class="product-gallery-btn product-degree-viewer" title="Product 360 Degree Gallery"><i class="w-icon-rotate-3d"></i></a>'),
                                c.isQuickView || d.append('<a href="#" class="product-gallery-btn product-video-viewer" title="Product Video Thumbnail"><i class="w-icon-movie"></i></a>'))),
                            ((o = c).$thumbs = o.$wrapper.find(".product-thumbs")),
                            (o.$thumbsWrap = o.$thumbs.parent()),
                            (o.$thumbUp = o.$thumbsWrap.find(".thumb-up")),
                            (o.$thumbDown = o.$thumbsWrap.find(".thumb-down")),
                            (o.$thumbsDots = o.$thumbs.children()),
                            (o.thumbsCount = o.$thumbsDots.length),
                            (o.$productThumb = o.$thumbsDots.eq(0)),
                            (o._isPgVertical = o.$thumbsWrap.parent().hasClass("product-gallery-vertical")),
                            (o.thumbsIsVertical = o._isPgVertical && window.innerWidth >= 992),
                            o.$thumbDown.on("click", function (e) {
                                o.thumbsIsVertical && a(o);
                            }),
                            o.$thumbUp.on("click", function (e) {
                                o.thumbsIsVertical && n(o);
                            }),
                            o.$thumbsDots.on("click", function (i) {
                                var a = e(this),
                                    n = (a.parent().filter(o.$thumbs).length ? a : a.parent()).index(),
                                    s = o.$wrapper.find(".product-single-carousel").data("owl.carousel");
                                s && s.to(n);
                            }),
                            s(o),
                            Wolmart.$window.on("resize", function () {
                                (o.thumbsIsVertical = o._isPgVertical && window.innerWidth >= 992), s(o);
                            });
                    })
                    .on("translate.owl.carousel", function (i) {
                        var a = (i.item.index - e(i.currentTarget).find(".cloned").length / 2 + i.item.count) % i.item.count;
                        c.setThumbsActive(a);
                    }),
                c.$wrapper.on("click", ".btn-wishlist", r),
                "complete" === Wolmart.status && (Wolmart.slider(d), Wolmart.initQtyInput(i.find(".quantity"))),
                c.$wrapper.find(".product-thumbs-sticky").length &&
                    ((c.isStickyScrolling = !1), c.$wrapper.on("click", ".product-thumb:not(.active)", c.clickStickyThumbnail.bind(this)), window.addEventListener("scroll", c.scrollStickyThumbnail.bind(this), { passive: !0 })),
                (l = this),
                (l.$selects = l.$wrapper.find(".product-variations select")),
                (l.$items = l.$wrapper.find(".product-variations")),
                (l.$priceWrap = l.$wrapper.find(".product-variation-price")),
                (l.$clean = l.$wrapper.find(".product-variation-clean")),
                (l.$btnCart = l.$wrapper.find(".btn-cart")),
                l.variationCheck(),
                l.$selects.on("change", function (e) {
                    l.variationCheck();
                }),
                l.$items.children("a").on("click", function (i) {
                    e(this).toggleClass("active").siblings().removeClass("active"), i.preventDefault(), l.variationCheck(), l.$items.parent(".product-image-swatch") && l.swatchImage();
                }),
                l.$clean.on("click", function (e) {
                    e.preventDefault(), l.variationClean(!0);
                });
        }),
            (ProductSingle.prototype.setThumbsActive = function (e) {
                var i = this,
                    a = i.$thumbsDots.eq(e);
                if ((i.$thumbsDots.filter(".active").removeClass("active"), a.addClass("active"), i.thumbsIsVertical)) {
                    var n = parseInt(i.$thumbs.css("top")) + e * i.thumbsHeight;
                    n < 0
                        ? i.$thumbs.css("top", parseInt(i.$thumbs.css("top")) - n)
                        : (n = i.$thumbs.offset().top + i.$thumbs[0].offsetHeight - a.offset().top - a[0].offsetHeight) < 0 && i.$thumbs.css("top", parseInt(i.$thumbs.css("top")) + n);
                } else
                    Wolmart.requestTimeout(function () {
                        i.$thumbs.data("owl.carousel") && i.$thumbs.data("owl.carousel").to(e);
                    }, 100);
            }),
            (ProductSingle.prototype.variationCheck = function () {
                var i = !0;
                this.$selects.each(function () {
                    return this.value || (i = !1);
                }),
                    this.$items.each(function () {
                        var a = e(this);
                        if (a.children("a:not(.size-guide)").length) return a.children(".active").length || (i = !1);
                    }),
                    i ? this.variationMatch() : this.variationClean();
            }),
            (ProductSingle.prototype.variationMatch = function () {
                this.$priceWrap.find("span").text("$" + (Math.round(50 * Math.random()) + 200) + ".00"), this.$priceWrap.slideDown(), this.$clean.slideDown(), this.$btnCart.removeClass("disabled");
            }),
            (ProductSingle.prototype.variationClean = function (e) {
                e && this.$selects.val(""), e && this.$items.children(".active").removeClass("active"), this.$priceWrap.slideUp(), this.$clean.css("display", "none"), this.$btnCart.addClass("disabled");
            }),
            (ProductSingle.prototype.clickStickyThumbnail = function (i) {
                var a = this,
                    n = e(i.currentTarget),
                    s = (n.parent().children(".active").index(), n.index() + 1);
                n.addClass("active").siblings(".active").removeClass("active"), (this.isStickyScrolling = !0);
                var o = n.closest(".product-thumbs-sticky").find(".product-image-wrapper > :nth-child(" + s + ")");
                o.length && ((o = o.offset().top + 10), Wolmart.scrollTo(o, 500)),
                    setTimeout(function () {
                        a.isStickyScrolling = !1;
                    }, 300);
            }),
            (ProductSingle.prototype.scrollStickyThumbnail = function () {
                var i = this;
                this.isStickyScrolling ||
                    i.$wrapper.find(".product-image-wrapper .product-image").each(function () {
                        if (Wolmart.isOnScreen(this))
                            return (
                                i.$wrapper
                                    .find(".product-thumbs > :nth-child(" + (e(this).index() + 1) + ")")
                                    .addClass("active")
                                    .siblings()
                                    .removeClass("active"),
                                !1
                            );
                    });
            }),
            (ProductSingle.prototype.swatchImage = function () {
                var e = this.$items.find(".active img").attr("src"),
                    i = this.$wrapper.find(".owl-item:first-child .product-image img"),
                    a = this.$wrapper.find(".owl-item:first-child .product-thumb img");
                i.attr("src", e), a.attr("src", e);
            }),
            (Wolmart.productSingle = function (i) {
                return (
                    Wolmart.$(i).each(function () {
                        var i = e(this);
                        i.is("body > *") || i.data("product-single", new ProductSingle(i));
                    }),
                    null
                );
            });
    })(jQuery),
    (function (e) {
        function i(i) {
            i.preventDefault();
            var a,
                n,
                s = e(i.currentTarget),
                o = s.closest(".product-single");
            if (
                (a = s.closest(".review-image").length
                    ? s.closest(".review-image").find("img")
                    : o.find(".product-single-carousel").length
                    ? o.find(".product-single-carousel .owl-item:not(.cloned) img:first-child")
                    : o.find(".product-gallery-carousel").length
                    ? o.find(".product-gallery-carousel .owl-item:not(.cloned) img")
                    : o.find(".product-image img:first-child")).length
            ) {
                n = a
                    .map(function () {
                        var i = e(this);
                        return { src: i.attr("data-zoom-image"), w: 800, h: 900, title: i.attr("alt") };
                    })
                    .get();
                var r = o.find(".product-single-carousel, .product-gallery-carousel").data("owl.carousel"),
                    l = r ? (r.current() - r.clones().length / 2 + n.length) % n.length : o.find(".product-gallery > *").index();
                if ("undefined" != typeof PhotoSwipe) {
                    var c = e(".pswp")[0],
                        d = new PhotoSwipe(c, PhotoSwipeUI_Default, n, { index: l, closeOnScroll: !1 });
                    d.init(), (Wolmart.photoSwipe = d);
                }
            }
        }
        function a(e) {
            e.preventDefault(), Wolmart.popup({ items: { src: '<video src="assets/video/memory-of-a-woman.mp4" autoplay loop controls>', type: "inline" }, mainClass: "mfp-video-popup" }, "video");
        }
        function n(i) {
            var a = e(this);
            a.addClass("active").siblings().removeClass("active"), a.parent().addClass("selected"), a.closest(".rating-form").find("select").val(a.text()), i.preventDefault();
        }
        function s(i) {
            var a = e(this),
                n = e(".main-content > .alert, .container > .alert");
            if (a.hasClass("disabled")) alert("Please select some product options before adding this product to your cart.");
            else {
                if (n.length)
                    n.fadeOut(function () {
                        n.fadeIn();
                    });
                else {
                    var s =
                        '<div class="alert alert-success alert-cart-product mb-2">                            <a href="cart.html" class="btn btn-success btn-rounded">View Cart</a>                            <p class="mb-0 ls-normal">\xe2?????' +
                        a.closest(".product-single").find(".product-title").text() +
                        '\xe2???\x9d has been added to your cart.</p>                            <a href="#" class="btn btn-link btn-close"><i class="close-icon"></i></a>                            </div>';
                    a.closest(".product-single").before(s);
                }
                e(".product-sticky-content").trigger("recalc.pin");
            }
        }
        Wolmart.initProductSinglePage = function () {
            Wolmart.zoomImage(".product-gallery .product-image"),
                (function (i) {
                    var a = e(i),
                        n = a.closest(".product-single"),
                        s =
                            '<div class="product product-list-sm mr-auto">                                        <figure class="product-media">                                        <img style="display: none;" src="" data-load="' +
                            n.find(".product-image img").eq(0).attr("src") +
                            '" alt="Product" width="85" height="85" />                                        </figure>                                        <div class="product-details pt-0 pl-2 pr-2">                                        <h4 class="product-name font-weight-normal mb-1">' +
                            n.find(".product-details .product-title").text() +
                            '</h4>                                        <div class="product-price mb-0">                                        <ins class="new-price">' +
                            n.find(".new-price").text() +
                            '</ins><del class="old-price">' +
                            n.find(".old-price").text() +
                            "</del></div>                                        </div></div>";
                    function o() {
                        a.hasClass("fix-top") && window.innerWidth > 767 && a.removeClass("fix-top").addClass("fix-bottom"),
                            (a.hasClass("fix-bottom") && window.innerWidth > 767) || (a.hasClass("fix-bottom") && window.innerWidth < 768 && a.removeClass("fix-bottom").addClass("fix-top"), a.hasClass("fix-top") && window.innerWidth);
                    }
                    a.find(".product-qty-form").before(s), window.addEventListener("resize", o, { passive: !0 }), o();
                })(".product-sticky-content"),
                document.body.classList.contains("home") ||
                    Wolmart.$body
                        .on("click", ".product-image-full", i)
                        .on("click", ".review-image img", i)
                        .on("click", ".product-video-viewer", a)
                        .on("click", ".product-degree-viewer", function (i) {
                            var a;
                            i.preventDefault(i),
                                e.fn.ThreeSixty &&
                                    ((a = i).preventDefault(),
                                    Wolmart.popup({
                                        type: "inline",
                                        mainClass: "product-popupbox wm-fade product-360-popup",
                                        preloader: !1,
                                        items: { src: '<div class="product-gallery-degree">						<div class="w-loading"><i></i></div>						<ul class="product-degree-images"></ul>					</div>' },
                                        callbacks: {
                                            open: function () {
                                                this.container
                                                    .find(".product-gallery-degree")
                                                    .ThreeSixty({
                                                        imagePath: "assets/images/products/video/",
                                                        filePrefix: "360-",
                                                        ext: ".jpg",
                                                        totalFrames: 18,
                                                        endFrame: 18,
                                                        currentFrame: 1,
                                                        imgList: this.container.find(".product-degree-images"),
                                                        progress: ".w-loading",
                                                        height: 500,
                                                        width: 830,
                                                        navigation: !0,
                                                    });
                                            },
                                            beforeClose: function () {
                                                this.container.empty();
                                            },
                                        },
                                    }));
                        })
                        .on("click", ".rating-form .rating-stars > a", n)
                        .on("click", ".product-single:not(.product-popup) .btn-cart", s);
        };
    })(jQuery),
    (function (e) {
        var i = function (e) {
            var i = this.settings.months[e.getMonth()];
            (i += this.settings.displayYear ? " " + e.getFullYear() : ""), this.element.find(".calendar-title").html(i);
        };
        (Calendar.defaultOptions = {
            months: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
            days: ["sunday", "monday", "tuesday", "wednesday", "thursday", "friday", "saturday"],
            displayYear: !0,
            fixedStartDay: !0,
            dayNumber: 0,
            dayExcerpt: 3,
        }),
            (Calendar.prototype.init = function (a, n) {
                (this.element = a), (this.settings = e.extend({}, !0, Calendar.defaultOptions, Wolmart.parseOptions(a.attr("data-calendar-options")), n)), (this.today = new Date()), (i = i.bind(this));
                var s = e('<div class="calendar"></div>'),
                    o = e(
                        '<div class="calendar-header"><a href="#" class="btn-calendar btn-calendar-prev"><i class="la la-angle-left"></i></a><span class="calendar-title"></span><a href="#" class="btn-calendar btn-calendar-next"><i class="la la-angle-right"></i></a></div>'
                    );
                s.append(o), a.append(s), i(this.today), this.render(this.today, s), this.bindEvents();
            }),
            (Calendar.prototype.render = function (i, a) {
                a.find("table") && a.find("table").remove();
                var n = e("<table></table>"),
                    s = e("<thead></thead>"),
                    o = e("<tbody></tbody"),
                    r = i.getFullYear(),
                    l = i.getMonth(),
                    c = new Date(r, l, 1),
                    d = new Date(r, l + 1, 0),
                    u = c.getDay();
                if (this.settings.fixedStartDay) {
                    for (u = this.settings.dayNumber; c.getDay() != u; ) c.setDate(c.getDate() - 1);
                    for (; d.getDay() != (u + 7) % 7; ) d.setDate(d.getDate() + 1);
                }
                for (var p = u; p < u + 7; p++) {
                    var h = e("<th>" + this.settings.days[p % 7].substring(0, this.settings.dayExcerpt) + "</th>");
                    p % 7 == 0 && h.addClass("holiday"), s.append(h);
                }
                for (var f = c; f < d; f.setDate(f.getDate())) {
                    var m = e("<tr></tr>");
                    for (p = 0; p < 7; p++) {
                        var g = e('<td><span class="day" data-date="' + f.toISOString() + '">' + f.getDate() + "</span></td>");
                        f.toDateString() == new Date().toDateString() && g.find(".day").addClass("today"), f.getMonth() != i.getMonth() && g.find(".day").addClass("disabled"), m.append(g), f.setDate(f.getDate() + 1);
                    }
                    o.append(m);
                }
                n.append(s), n.append(o), a.append(n);
            }),
            (Calendar.prototype.changeMonth = function (a) {
                this.today.setMonth(this.today.getMonth() + a, 1), this.render(this.today, e(this.element).find(".calendar")), i(this.today);
            }),
            (Calendar.prototype.bindEvents = function () {
                var i = this;
                e(i.element)
                    .find(".btn-calendar-prev")
                    .on("click", function (e) {
                        i.changeMonth(-1), e.preventDefault();
                    }),
                    e(i.element)
                        .find(".btn-calendar-next")
                        .on("click", function (e) {
                            i.changeMonth(1), e.preventDefault();
                        });
            }),
            (Wolmart.calendar = function (i, a) {
                Wolmart.$(i).each(function () {
                    var i = e(this);
                    Wolmart.call(function () {
                        new Calendar(i, a);
                    });
                });
            }),
            (Wolmart.initVendor = function (i) {
                var a = e(i),
                    n = a.closest(".page-content").find(".toolbox .vendor-search-toggle"),
                    s = a.find(".store-phone");
                n.on("click", function (e) {
                    var i = n.closest(".vendor-toolbox").next(".vendor-search-wrapper");
                    i.hasClass("open") ? i.removeClass("open").slideUp() : i.addClass("open").slideDown(), e.preventDefault();
                }),
                    s.on("click", function () {
                        alert("Always open these types of links in the associated app");
                    });
            }),
            (Wolmart.slideContent = function (i) {
                var a = e(i),
                    n = a.next();
                a.on("click", function (e) {
                    e.preventDefault(), n.hasClass("open") ? (n.removeClass("open").slideUp(), a.find(".custom-checkbox").removeClass("checked")) : (n.addClass("open").slideDown(), a.find(".custom-checkbox").addClass("checked"));
                });
            }),
            (Wolmart.initLoginVendor = function (i) {
                var a = e(i),
                    n = a.parent().find(".login-vendor"),
                    s = a.find(".check-customer");
                a.find(".check-seller").on("click", function () {
                    a.find("#check-seller").addClass("active"), a.find("#check-customer").removeClass("active"), n.slideDown();
                }),
                    s.on("click", function () {
                        a.find("#check-customer").addClass("active"), a.find("#check-seller").removeClass("active"), n.slideUp();
                    });
            });
    })(jQuery),
    jQuery,
    (Wolmart.prepare = function () {
        Wolmart.$body.hasClass("with-flex-container") && window.innerWidth >= 1200 && Wolmart.$body.addClass("sidebar-active");
    }),
    (Wolmart.initLayout = function () {
        Wolmart.isotopes(".grid:not(.grid-float)"), Wolmart.stickySidebar(".sticky-sidebar");
    }),
    (Wolmart.init = function () {
        Wolmart.appearAnimate(".appear-animate"),
            Wolmart.slider(".owl-carousel"),
            Wolmart.setTab(".nav-tabs"),
            Wolmart.stickyContent(".sticky-header"),
            Wolmart.stickyContent(".sticky-footer", { minWidth: 0, maxWidth: 767, top: 150, hide: !0, max_index: 2100 }),
            Wolmart.stickyContent(".sticky-toolbox", Wolmart.stickyToolboxOptions),
            Wolmart.stickyContent(".product-sticky-content", Wolmart.stickyProductOptions),
            Wolmart.parallax(".parallax"),
            Wolmart.skrollrParallax(),
            Wolmart.initFloatingParallax(),
            Wolmart.menu.init(),
            Wolmart.initScrollTopButton(),
            Wolmart.shop.init(),
            Wolmart.alert(".alert"),
            Wolmart.accordion(".card-header > a"),
            Wolmart.sidebar("sidebar"),
            Wolmart.sidebar("right-sidebar"),
            Wolmart.productSingle(".product-single"),
            Wolmart.initProductSinglePage(),
            Wolmart.initQtyInput(".quantity"),
            Wolmart.initNavFilter(".nav-filters .nav-filter"),
            Wolmart.calendar(".calendar-container"),
            Wolmart.countDown(".product-countdown, .countdown"),
            Wolmart.initNotificationAlert(),
            Wolmart.countTo(".count-to"),
            Wolmart.initCartAction(".cart-offcanvas .cart-toggle"),
            Wolmart.Minipopup.init(),
            Wolmart.headerToggleSearch(".hs-toggle"),
            Wolmart.initVendor(".store"),
            Wolmart.slideContent(".login-toggle"),
            Wolmart.slideContent(".coupon-toggle"),
            Wolmart.slideContent(".checkbox-toggle"),
            Wolmart.initLoginVendor(".user-checkbox");
    }),
    jQuery,
    Wolmart.prepare(),
    (document.onreadystatechange = function () {
        document.readyState;
    }),
    (window.onload = function () {
        (Wolmart.status = "loaded"),
            (Wolmart.$body.addClass = "loaded"),
            Wolmart.$window.trigger("wolmart_loaded"),
            Wolmart.call(Wolmart.initLayout),
            Wolmart.call(Wolmart.init),
            (Wolmart.status = "complete"),
            Wolmart.$window.trigger("wolmart_complete");
    });
