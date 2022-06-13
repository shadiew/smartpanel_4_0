/*!
 * Tabler v1.0.0 (https://tabler.io)
 * Copyright 2018-2019 codecalm
 * Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
 */
'use strict';

function _classCallCheck(a, b) {
    if (!(a instanceof b)) throw new TypeError("Cannot call a class as a function")
}

function _defineProperties(a, b) {
    for (var c, d = 0; d < b.length; d++) c = b[d], c.enumerable = c.enumerable || !1, c.configurable = !0, "value" in c && (c.writable = !0), Object.defineProperty(a, c.key, c)
}

function _createClass(a, b, c) {
    return b && _defineProperties(a.prototype, b), c && _defineProperties(a, c), a
}
var ThemeCustomizer = function() {
    function a() {
        var b = this;
        if (_classCallCheck(this, a), this.init(), this.form = document.querySelector(".js-layout-form"), this.form) {
            this.form.addEventListener("submit", function(a) {
                a.preventDefault(), b.onSubmitForm()
            });
            for (var c = this.form.querySelectorAll("input[type=\"radio\"]"), d = 0; d < c.length; d++) c[d].addEventListener("change", function() {
                b.onSubmitForm()
            })
        }
        this.initFormControls()
    }
    return _createClass(a, [{
        key: "init",
        value: function() {
            this.config = this.getConfig()
        }
    }, {
        key: "getConfig",
        value: function() {
            return {
                colorScheme: localStorage.getItem("tablerColorScheme") ? localStorage.getItem("tablerColorScheme") : "light",
                navPosition: localStorage.getItem("tablerNavPosition") ? localStorage.getItem("tablerNavPosition") : "side",
                headerColor: localStorage.getItem("tablerHeaderColor") ? localStorage.getItem("tablerHeaderColor") : "light",
                headerFixed: localStorage.getItem("tablerHeaderFixed") ? localStorage.getItem("tablerHeaderFixed") : "default",
                sidebarColor: localStorage.getItem("tablerSidebarColor") ? localStorage.getItem("tablerSidebarColor") : "dark",
                sidebarSize: localStorage.getItem("tablerSidebarSize") ? localStorage.getItem("tablerSidebarSize") : "default",
                sidebarPosition: localStorage.getItem("tablerSidebarPosition") ? localStorage.getItem("tablerSidebarPosition") : "left",
                sidebarFixed: localStorage.getItem("tablerSidebarFixed") ? localStorage.getItem("tablerSidebarFixed") : "fixed"
            }
        }
    }, {
        key: "setConfig",
        value: function(a, b, c, d) {
            return c && -1 !== c.indexOf(b) && (a = "tabler" + a.charAt(0).toUpperCase() + a.slice(1), localStorage.setItem(a, b), d && d(b)), this.getConfig()
        }
    }, {
        key: "onSubmitForm",
        value: function() {
            var a = this.form;
            this.toggleColorScheme(a.querySelector("[name=\"color-scheme\"]:checked").value), this.toggleNavPosition(a.querySelector("[name=\"nav-position\"]:checked").value), this.toggleHeaderColor(a.querySelector("[name=\"header-color\"]:checked").value), this.toggleSidebarSize(a.querySelector("[name=\"sidebar-size\"]:checked").value), this.toggleSidebarColor(a.querySelector("[name=\"sidebar-color\"]:checked").value), this.toggleSidebarPosition(a.querySelector("[name=\"sidebar-position\"]:checked").value), this.toggleSidebarFixed(a.querySelector("[name=\"sidebar-fixed\"]:checked").value)
        }
    }, {
        key: "initFormControls",
        value: function() {
            var a = this.getConfig();
            this.toggleColorScheme(a.colorScheme), this.toggleNavPosition(a.navPosition), this.toggleHeaderColor(a.headerColor), this.toggleSidebarPosition(a.sidebarPosition), this.toggleSidebarSize(a.sidebarSize), this.toggleSidebarColor(a.sidebarColor), this.toggleSidebarFixed(a.sidebarFixed)
        }
    }, {
        key: "setFormValue",
        value: function(a, b) {
            if (this.form) {
                var c = this.form.querySelectorAll("[name=\"".concat(a, "\"]"));
                c && (c.forEach(function(a) {
                    return a.checked = !1
                }), this.form.querySelector("[name=\"".concat(a, "\"][value=\"").concat(b, "\"]")).checked = !0)
            }
        }
    }, {
        key: "toggleColorScheme",
        value: function(a) {
            var b = this;
            return this.setConfig("colorScheme", a, ["dark", "light"], function() {
                "dark" === a ? document.body.classList.add("theme-dark") : document.body.classList.remove("theme-dark"), b.setFormValue("color-scheme", a)
            })
        }
    }, {
        key: "toggleNavPosition",
        value: function(a) {
            var b = this;
            return this.setConfig("navPosition", a, ["top", "side"], function() {
                b.setFormValue("nav-position", a)
            })
        }
    }, {
        key: "toggleSidebarPosition",
        value: function(a) {
            var b = this;
            return this.setConfig("sidebarPosition", a, ["left", "right"], function() {
                "right" === a ? document.querySelector(".js-sidebar").classList.add("navbar-right") : document.querySelector(".js-sidebar").classList.remove("navbar-right"), b.setFormValue("sidebar-position", a)
            })
        }
    }, {
        key: "toggleSidebarSize",
        value: function(a) {
            var b = this;
            return this.setConfig("sidebarSize", a, ["default", "folded"], function() {
            	if ("folded" === a) {
            		$('.navbar-side [data-toggle="tooltip"]').tooltip('enable');
                	document.querySelector(".js-sidebar").classList.add("navbar-folded");
                    document.querySelector(".vertical-menu").classList.add("menu-folded");
                    document.querySelector(".vertical-menu").classList.remove("menu-expanded");
            	}else{
            		$('.navbar-side [data-toggle="tooltip"]').tooltip('disable');
            		document.querySelector(".js-sidebar").classList.remove("navbar-folded"), b.setFormValue("sidebar-size", a);
                    document.querySelector(".vertical-menu").classList.add("menu-expanded");
                    document.querySelector(".vertical-menu").classList.remove("menu-folded");
            	}
            })
        }
    }, {
        key: "toggleSidebarColor",
        value: function(a) {
            var b = this;
            return this.setConfig("sidebarColor", a, ["dark", "light"], function() {
                "dark" === a ? document.querySelector(".js-sidebar").classList.add("navbar-dark") : document.querySelector(".js-sidebar").classList.remove("navbar-dark"), b.setFormValue("sidebar-color", a)
            })
        }
    }, {
        key: "toggleSidebarFixed",
        value: function(a) {
            var b = this;
            return this.setConfig("sidebarFixed", a, ["fixed", "default"], function() {
                "fixed" === a ? document.querySelector(".js-sidebar").classList.add("navbar-fixed") : document.querySelector(".js-sidebar").classList.remove("navbar-fixed"), b.setFormValue("sidebar-fixed", a)
            })
        }
    }, {
        key: "toggleHeaderColor",
        value: function(a) {
            var b = this;
            return this.setConfig("headerColor", a, ["dark", "light"], function() {
                "dark" === a ? document.querySelector(".js-header").classList.add("navbar-dark") : document.querySelector(".js-header").classList.remove("navbar-dark"), b.setFormValue("header-color", a)
            })
        }
    }, {
        key: "toggleHeaderFixed",
        value: function(a) {
            var b = this;
            return this.setConfig("headerFixed", a, ["fixed", "default"], function() {
                "fixed" === a ? document.querySelector(".js-header").classList.add("navbar-fixed") : document.querySelector(".js-header").classList.remove("navbar-fixed"), b.setFormValue("header-fixed", a)
            })
        }
    }]), a
}();

(function() {
    var a = new ThemeCustomizer;
    window.DEMO = a
})();