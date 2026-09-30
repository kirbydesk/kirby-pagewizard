(function() {
  "use strict";
  function normalizeComponent(scriptExports, render, staticRenderFns, functionalTemplate, injectStyles, scopeId, moduleIdentifier, shadowMode) {
    var options = typeof scriptExports === "function" ? scriptExports.options : scriptExports;
    if (render) {
      options.render = render;
      options.staticRenderFns = staticRenderFns;
      options._compiled = true;
    }
    if (scopeId) {
      options._scopeId = "data-v-" + scopeId;
    }
    return {
      exports: scriptExports,
      options
    };
  }
  const _sfc_main$8 = {};
  var _sfc_render$8 = function render() {
    var _vm = this, _c = _vm._self._c;
    return _c("div", { staticClass: "pwPreview", on: { "dblclick": _vm.open } }, [_vm.content.name ? _c("div", { staticClass: "heading" }, [_vm._v(" " + _vm._s(_vm.content.name) + " ")]) : _c("div", { staticClass: "heading placeholder" }, [_vm._v(" " + _vm._s(_vm.$t("pw.footer.name")) + " ... ")]), _vm._l(_vm.content.blocks, function(item) {
      return _c("div", { key: item.id, staticClass: "items" }, [_c("div", { staticClass: "linktext", class: { placeholder: !item.content.linktext } }, [_c("span", [_vm._v(_vm._s(item.content.linktext || _vm.$t("pw.field.link-text.placeholder")))]), item.content.linktarget ? _c("span", { staticClass: "k-icon" }, [_c("k-icon", { attrs: { "type": "open" } })], 1) : _vm._e()])]);
    })], 2);
  };
  var _sfc_staticRenderFns$8 = [];
  _sfc_render$8._withStripped = true;
  var __component__$8 = /* @__PURE__ */ normalizeComponent(
    _sfc_main$8,
    _sfc_render$8,
    _sfc_staticRenderFns$8,
    false,
    null,
    "40650bd6"
  );
  __component__$8.options.__file = "/Users/christian/Projects/pluginsources/kirby-pagewizard/src/blocks/footer/index.vue";
  const pwFooter = __component__$8.exports;
  const _sfc_main$7 = {};
  var _sfc_render$7 = function render() {
    var _vm = this, _c = _vm._self._c;
    return _c("div", { staticClass: "pwPreview", on: { "dblclick": _vm.open } }, [_vm.content.linktext ? _c("div", { staticClass: "linktext" }, [_c("span", [_vm._v(_vm._s(_vm.content.linktext))]), _vm.content.linktarget ? _c("span", { staticClass: "k-icon" }, [_c("k-icon", { attrs: { "type": "open" } })], 1) : _vm._e()]) : _c("div", { staticClass: "placeholder" }, [_vm._v(" " + _vm._s(_vm.$t("pw.field.link-text.placeholder")) + " ")])]);
  };
  var _sfc_staticRenderFns$7 = [];
  _sfc_render$7._withStripped = true;
  var __component__$7 = /* @__PURE__ */ normalizeComponent(
    _sfc_main$7,
    _sfc_render$7,
    _sfc_staticRenderFns$7,
    false,
    null,
    "f57ea2ba"
  );
  __component__$7.options.__file = "/Users/christian/Projects/pluginsources/kirby-pagewizard/src/blocks/footer/item.vue";
  const pwFooterItem = __component__$7.exports;
  const _sfc_main$6 = {
    data() {
      return { sharedItems: [] };
    },
    computed: {
      label() {
        const item = this.sharedItems.find((i) => i.value === this.content.sharedid);
        return (item == null ? void 0 : item.label) || this.content.sharedid || "";
      },
      icon() {
        const item = this.sharedItems.find((i) => i.value === this.content.sharedid);
        return (item == null ? void 0 : item.icon) || null;
      },
      blockName() {
        const item = this.sharedItems.find((i) => i.value === this.content.sharedid);
        return (item == null ? void 0 : item.name) || "";
      }
    },
    async created() {
      try {
        const r = await this.$api.get("pagewizard/shared");
        this.sharedItems = Array.isArray(r) ? r : [];
      } catch (e) {
        this.sharedItems = [];
      }
    }
  };
  var _sfc_render$6 = function render() {
    var _vm = this, _c = _vm._self._c;
    return _c("div", { staticClass: "pwPreview", attrs: { "data-kirbyblock": "shared" }, on: { "dblclick": _vm.open } }, [_c("div", { staticClass: "shared" }, [_c("div", { staticClass: "name" }, [_vm.icon ? _c("k-icon", { attrs: { "type": _vm.icon } }) : _vm._e(), _c("span", { staticClass: "blockname" }, [_vm._v(_vm._s(_vm.blockName))])], 1), _c("span", [_vm._v("|")]), _c("em", { staticClass: "sharedname" }, [_vm._v(_vm._s(_vm.label))])])]);
  };
  var _sfc_staticRenderFns$6 = [];
  _sfc_render$6._withStripped = true;
  var __component__$6 = /* @__PURE__ */ normalizeComponent(
    _sfc_main$6,
    _sfc_render$6,
    _sfc_staticRenderFns$6,
    false,
    null,
    "dd19bc81"
  );
  __component__$6.options.__file = "/Users/christian/Projects/pluginsources/kirby-pagewizard/src/blocks/shared/index.vue";
  const pwshared = __component__$6.exports;
  const _sfc_main$5 = {
    props: {
      content: { type: Object, default: () => ({}) },
      alignDefault: { type: String, default: "left" }
    },
    computed: {
      align() {
        return this.content.buttonalignment || this.alignDefault;
      },
      isExternal() {
        return this.content.linktype == true && this.content.linktarget == true;
      },
      icon() {
        const pos = this.content.iconposition;
        if (pos === "right") return this.content.iconright || "";
        if (pos === "left") return this.content.iconleft || "";
        return "";
      }
    }
  };
  var _sfc_render$5 = function render() {
    var _a;
    var _vm = this, _c = _vm._self._c;
    return _c("div", { staticClass: "pwButton", attrs: { "data-align": _vm.align } }, [_c("button", { staticClass: "k-button", attrs: { "data-has-text": "true", "data-responsive": "true", "data-size": "sm", "data-variant": "filled", "type": "button" } }, [_vm.icon && _vm.content.iconposition === "left" ? _c("span", { staticClass: "pw-link-icon", domProps: { "innerHTML": _vm._s(_vm.icon) } }) : _vm._e(), ((_a = _vm.content.linktext) == null ? void 0 : _a.length) ? _c("span", { staticClass: "k-button-text", domProps: { "innerHTML": _vm._s(_vm.content.linktext) } }) : _c("span", { staticClass: "k-button-text placeholder" }, [_vm._v(" " + _vm._s(_vm.$t("pw.field.link-text.placeholder")) + " ")]), _vm.icon && _vm.content.iconposition === "right" ? _c("span", { staticClass: "pw-link-icon", domProps: { "innerHTML": _vm._s(_vm.icon) } }) : _vm._e(), _vm.isExternal ? _c("svg", { staticClass: "pw-external-icon", attrs: { "aria-hidden": "true", "viewBox": "0 0 24 24", "fill": "currentColor" } }, [_c("path", { attrs: { "d": "M10 6V8H5V19H16V14H18V20C18 20.5523 17.5523 21 17 21H4C3.44772 21 3 20.5523 3 20V7C3 6.44772 3.44772 6 4 6H10ZM21 3V11H19L18.9999 6.413L11.2071 14.2071L9.79289 12.7929L17.5849 5H13V3H21Z" } })]) : _vm._e()])]);
  };
  var _sfc_staticRenderFns$5 = [];
  _sfc_render$5._withStripped = true;
  var __component__$5 = /* @__PURE__ */ normalizeComponent(
    _sfc_main$5,
    _sfc_render$5,
    _sfc_staticRenderFns$5,
    false,
    null,
    "10e849d1"
  );
  __component__$5.options.__file = "/Users/christian/Projects/pluginsources/kirby-pagewizard/src/components/button.vue";
  const pwButton = __component__$5.exports;
  const _sfc_main$4 = {
    props: {
      value: String,
      align: {
        type: String,
        default: "left"
      }
    },
    methods: {
      iconOf(item) {
        const pos = item.content.iconposition;
        if (pos === "right") return item.content.iconright || "";
        if (pos === "left") return item.content.iconleft || "";
        return "";
      }
    }
  };
  var _sfc_render$4 = function render() {
    var _vm = this, _c = _vm._self._c;
    return _vm.value && _vm.value.length ? _c("div", { staticClass: "k-button-group", attrs: { "data-align": _vm.align } }, _vm._l(_vm.value, function(item) {
      return _c("div", { key: item.id, class: { "ishidden": item.isHidden } }, [_c("button", { staticClass: "k-button", attrs: { "type": "button", "data-has-text": "true", "data-responsive": "true", "data-size": "md", "data-variant": "filled" } }, [_vm.iconOf(item) && item.content.iconposition === "left" ? _c("span", { staticClass: "pw-link-icon", domProps: { "innerHTML": _vm._s(_vm.iconOf(item)) } }) : _vm._e(), item.content.linktext.length ? _c("span", { staticClass: "k-button-text" }, [_vm._v(" " + _vm._s(item.content.linktext) + " ")]) : _c("span", { staticClass: "k-button-text placeholder" }, [_vm._v(" " + _vm._s(_vm.$t("pw.field.link-text.placeholder")) + " ")]), _vm.iconOf(item) && item.content.iconposition === "right" ? _c("span", { staticClass: "pw-link-icon", domProps: { "innerHTML": _vm._s(_vm.iconOf(item)) } }) : _vm._e(), item.content.linktype == true && item.content.linktarget == true ? _c("svg", { staticClass: "pw-external-icon", attrs: { "aria-hidden": "true", "viewBox": "0 0 24 24", "fill": "currentColor" } }, [_c("path", { attrs: { "d": "M10 6V8H5V19H16V14H18V20C18 20.5523 17.5523 21 17 21H4C3.44772 21 3 20.5523 3 20V7C3 6.44772 3.44772 6 4 6H10ZM21 3V11H19L18.9999 6.413L11.2071 14.2071L9.79289 12.7929L17.5849 5H13V3H21Z" } })]) : _vm._e()])]);
    }), 0) : _vm._e();
  };
  var _sfc_staticRenderFns$4 = [];
  _sfc_render$4._withStripped = true;
  var __component__$4 = /* @__PURE__ */ normalizeComponent(
    _sfc_main$4,
    _sfc_render$4,
    _sfc_staticRenderFns$4,
    false,
    null,
    "a81c040e"
  );
  __component__$4.options.__file = "/Users/christian/Projects/pluginsources/kirby-pagewizard/src/components/buttons.vue";
  const pwButtons = __component__$4.exports;
  const PATHS = {
    textbackground: {
      disabled: '<path d="M9 4.9967V11.2694H7V4.9967H5V13.9967H19V4.9967H9ZM20 15.9967H4V17.9967H20V15.9967ZM3 13.9967V3.9967C3 3.44442 3.44772 2.9967 4 2.9967H20C20.5523 2.9967 21 3.44442 21 3.9967V13.9967H22V18.9967C22 19.549 21.5523 19.9967 21 19.9967H13V22.9967H11V19.9967H3C2.44772 19.9967 2 19.549 2 18.9967V13.9967H3Z"/>',
      enabled: '<path d="M20 15.9967H4V17.9967H20V15.9967ZM3 13.9967V3.9967C3 3.44442 3.44772 2.9967 4 2.9967H7V11.2694H9V2.9967H20C20.5523 2.9967 21 3.44442 21 3.9967V13.9967H22V18.9967C22 19.549 21.5523 19.9967 21 19.9967H13V22.9967H11V19.9967H3C2.44772 19.9967 2 19.549 2 18.9967V13.9967H3Z"/>'
    },
    multiline: {
      disabled: '<path d="M5 19H19V5H5V19ZM3 4C3 3.44772 3.44772 3 4 3H20C20.5523 3 21 3.44772 21 4V20C21 20.5523 20.5523 21 20 21H4C3.44772 21 3 20.5523 3 20V4ZM10 8V11H14V8L18 12L14 16V13H10V16L6 12L10 8Z"/>',
      enabled: '<path d="M5 19H19V5H5V19ZM3 4C3 3.44772 3.44772 3 4 3H20C20.5523 3 21 3.44772 21 4V20C21 20.5523 20.5523 21 20 21H4C3.44772 21 3 20.5523 3 20V4ZM8 10L12 6L16 10H13V14H16L12 18L8 14H11V10L8 10Z"/>'
    },
    flourish: {
      disabled: '<path d="M5.55397 22H3.3999L10.9999 3H12.9999L20.5999 22H18.4458L16.0458 16H7.95397L5.55397 22ZM8.75397 14H15.2458L11.9999 5.88517L8.75397 14Z"/>',
      enabled: '<path d="M15.2459 14H8.75407L7.15407 18H5L11 3H13L19 18H16.8459L15.2459 14ZM14.4459 12L12 5.88516L9.55407 12H14.4459ZM3 20H21V22H3V20Z"/>'
    }
  };
  function hasIcon(type, value) {
    if (type === "size" || type === "mode") return false;
    if (type === "align") return !!value;
    return ["level", "textbackground", "multiline", "flourish"].includes(type);
  }
  function iconHtml(type, value) {
    if (PATHS[type]) return PATHS[type][value] || PATHS[type].disabled;
    const name = type === "align" ? "text-" + value : value === "div" ? "pw-level-div" : value;
    return '<use href="#icon-' + name + '"></use>';
  }
  function optionText(type, value, t, options) {
    if (type === "mode") return t("pw.field.text-" + value, value);
    if (type === "align" && !value) return "···";
    if (type === "size" && Array.isArray(options) && options.includes("normal")) return t("pw.option.text-" + value, value);
    if (type === "style") return t("pw.option.list-" + value, value);
    return t("pw.option." + value, value);
  }
  const _sfc_main$3 = {
    props: {
      // level, size, align, textbackground, multiline, flourish, mode
      type: { type: String, required: true },
      value: { type: String, default: "" },
      // all options of the dropdown (tells the texts' size scale apart)
      options: { type: Array, default: null }
    },
    computed: {
      isIcon() {
        return hasIcon(this.type, this.value);
      },
      html() {
        return iconHtml(this.type, this.value);
      },
      text() {
        return optionText(this.type, this.value, (key, fallback) => this.$t(key, fallback), this.options);
      }
    }
  };
  var _sfc_render$3 = function render() {
    var _vm = this, _c = _vm._self._c;
    return _vm.isIcon ? _c("span", { staticClass: "k-button-icon" }, [_c("svg", { staticClass: "k-icon", attrs: { "aria-hidden": "true", "viewBox": "0 0 24 24", "fill": "currentColor" }, domProps: { "innerHTML": _vm._s(_vm.html) } })]) : _c("span", { staticClass: "k-button-text pw-size-label" }, [_vm._v(_vm._s(_vm.text))]);
  };
  var _sfc_staticRenderFns$3 = [];
  _sfc_render$3._withStripped = true;
  var __component__$3 = /* @__PURE__ */ normalizeComponent(
    _sfc_main$3,
    _sfc_render$3,
    _sfc_staticRenderFns$3,
    false,
    null,
    null
  );
  __component__$3.options.__file = "/Users/christian/Projects/pluginsources/kirby-pagewizard/src/components/option-icon.vue";
  const pwOptionIcon = __component__$3.exports;
  const _sfc_main$2 = {
    components: { pwOptionIcon },
    props: {
      // [{ key: 'level' | 'size' | 'align' | 'textbackground' | 'multiline' |
      //    'flourish' | 'mode', value, options: [...], locked? }] in the order
      //    shown (locked: the value is set elsewhere, the menu stays shut)
      items: { type: Array, default: () => [] }
    },
    emits: ["input"],
    data() {
      return {
        // the open dropdown (one at a time)
        open: null
      };
    },
    methods: {
      isIcon(key, value) {
        return hasIcon(key, value);
      },
      toggle(key) {
        this.open = this.open === key ? null : key;
      },
      choose(key, value) {
        this.open = null;
        this.$emit("input", { key, value });
      },
      onClickOutside(event) {
        if (!this.$el.contains(event.target)) this.open = null;
      },
      onEscape(event) {
        if (event.key === "Escape" && this.open) {
          event.stopPropagation();
          event.preventDefault();
          this.open = null;
        }
      }
    },
    mounted() {
      document.addEventListener("click", this.onClickOutside, true);
      document.addEventListener("keydown", this.onEscape);
    },
    beforeDestroy() {
      document.removeEventListener("click", this.onClickOutside, true);
      document.removeEventListener("keydown", this.onEscape);
    }
  };
  var _sfc_render$2 = function render() {
    var _vm = this, _c = _vm._self._c;
    return _c("div", { staticClass: "k-button-group pw-field-toolbar" }, _vm._l(_vm.items, function(item) {
      return _c("span", { key: item.key, staticClass: "pw-field-toolbar-item" }, [_c("button", { staticClass: "input-focus k-button", attrs: { "data-has-icon": _vm.isIcon(item.key, item.value) ? "true" : "false", "data-has-text": _vm.isIcon(item.key, item.value) ? "false" : "true", "aria-label": _vm.$t("pw.toolbar." + item.key), "title": _vm.$t("pw.toolbar." + item.key), "data-size": "xs", "data-variant": "filled", "type": "button", "disabled": item.locked || null }, on: { "click": function($event) {
        $event.stopPropagation();
        !item.locked && _vm.toggle(item.key);
      } } }, [_c("pw-option-icon", { attrs: { "type": item.key, "value": item.value, "options": item.options } }), _c("span", { staticClass: "k-button-arrow" }, [_c("k-icon", { attrs: { "type": "angle-dropdown" } })], 1)], 1), _vm.open === item.key ? _c("dialog", { staticClass: "k-dropdown-content pw-dropdown", attrs: { "data-theme": "dark", "open": "" } }, [_c("div", { staticClass: "k-navigate" }, _vm._l(item.options, function(option) {
        return _c("button", { key: option, staticClass: "k-button k-dropdown-item", attrs: { "type": "button", "data-has-icon": _vm.isIcon(item.key, option) ? "true" : "false", "data-has-text": _vm.isIcon(item.key, option) ? "false" : "true", "aria-current": option === item.value ? "true" : void 0 }, on: { "click": function($event) {
          $event.stopPropagation();
          return _vm.choose(item.key, option);
        } } }, [_c("pw-option-icon", { attrs: { "type": item.key, "value": option, "options": item.options } })], 1);
      }), 0)]) : _vm._e()]);
    }), 0);
  };
  var _sfc_staticRenderFns$2 = [];
  _sfc_render$2._withStripped = true;
  var __component__$2 = /* @__PURE__ */ normalizeComponent(
    _sfc_main$2,
    _sfc_render$2,
    _sfc_staticRenderFns$2,
    false,
    null,
    null
  );
  __component__$2.options.__file = "/Users/christian/Projects/pluginsources/kirby-pagewizard/src/components/field-toolbar.vue";
  const pwFieldToolbar = __component__$2.exports;
  const htmlheadline = {
    props: {
      label: String,
      help: String
    },
    computed: {
      translatedLabel() {
        return this.$t(this.label, this.label);
      },
      dataTheme() {
        return this.$attrs["data-theme"] || null;
      }
    },
    template: `
		<header class="k-headline-field" :data-theme="dataTheme">
			<h2 class="k-headline" v-html="translatedLabel"></h2>
			<footer v-if="help" class="k-field-footer">
				<div class="k-help k-field-help k-text" v-html="help"></div>
			</footer>
		</header>
	`
  };
  const pwtext = {
    extends: "k-text-field",
    props: {
      label: String,
      help: String,
      placeholder: String,
      value: String,
      align: String,
      level: String,
      size: String,
      textbackground: String,
      multiline: String,
      flourish: String,
      alignOptions: {
        default: null
      },
      levelOptions: {
        default: null
      },
      sizeOptions: {
        type: Array,
        default: null
      },
      textbackgroundOptions: {
        type: Array,
        default: null
      },
      multilineOptions: {
        type: Array,
        default: null
      },
      flourishOptions: {
        type: Array,
        default: null
      }
    },
    data() {
      const parsed = this.parseValue();
      return {
        current: {
          align: parsed.align || this.align || "left",
          level: parsed.level || this.level || "h2",
          size: parsed.size || this.size || "2xl",
          textbackground: parsed.textbackground || this.textbackground || null,
          multiline: parsed.multiline || this.multiline || null,
          flourish: parsed.flourish || this.flourish || null
        }
      };
    },
    computed: {
      // the dropdowns shown (each only with its preset and options), in the
      // order of the drawer
      toolbarItems() {
        return ["flourish", "multiline", "textbackground", "align", "size", "level"].filter((key) => this[key] && this[key + "Options"]).map((key) => ({ key, value: this.current[key], options: this[key + "Options"] }));
      }
    },
    watch: {
      value() {
        const parsed = this.parseValue();
        for (const key of Object.keys(this.current)) {
          if (parsed[key]) this.current[key] = parsed[key];
        }
      }
    },
    methods: {
      parseValue() {
        if (!this.value) return {};
        try {
          return typeof this.value === "string" ? JSON.parse(this.value) : this.value;
        } catch (e) {
          return { text: this.value };
        }
      },
      emitValue(text) {
        const { align, level, size, textbackground, multiline, flourish } = this.current;
        const data = { text, align, level, size };
        if (textbackground) data.textbackground = textbackground;
        if (multiline) data.multiline = multiline;
        if (flourish) data.flourish = flourish;
        this.$emit("input", JSON.stringify(data));
      },
      // a dropdown chose a value
      setOption({ key, value }) {
        this.current[key] = value;
        this.emitValue(this.parseValue().text || "");
      },
      handleInput(event) {
        this.emitValue(event.target.value);
      }
    },
    template: `
		<div class="k-field k-text-field" :data-align="current.align" :data-level="current.level" :data-size="current.size">
			<header class="k-field-header" style="display:flex;align-items:center;overflow:visible;">
				<label v-if="label" class="k-label k-field-label" style="flex:1;">
					<span class="k-label-text">{{ label }}</span>
				</label>
				<span v-else style="flex:1;"></span>
				<pw-field-toolbar v-if="toolbarItems.length" :items="toolbarItems" @input="setOption" />
			</header>
			<div class="k-input" data-type="text">
				<span class="k-input-element">
					<textarea
						v-if="current.multiline === 'enabled'"
						:value="parseValue().text || ''"
						@input="handleInput"
						:placeholder="placeholder"
						class="k-textarea-input"
						rows="3"
						style="width:100%;font:inherit;resize:vertical;padding:0.5rem;"
					></textarea>
					<input
						v-else
						:value="parseValue().text || ''"
						@input="handleInput"
						:placeholder="placeholder"
						type="text"
						class="k-string-input k-text-input"
					/>
				</span>
			</div>
			<footer v-if="help" class="k-field-footer">
				<div class="k-help k-field-help k-text" v-html="help"></div>
			</footer>
		</div>
	`
  };
  const pweditor = {
    props: {
      value: String,
      label: String,
      placeholder: String,
      fieldHelp: String,
      align: { type: String, default: "left" },
      alignOptions: { type: Array, default: () => ["left", "center", "right"] },
      size: { type: String, default: null },
      sizeOptions: { type: Array, default: null },
      defaultMode: { type: String, default: null },
      writerModes: { type: Array, default: () => ["textarea", "writer"] },
      writerMarks: { type: Array, default: () => ["bold", "italic", "underline", "strike", "link"] },
      writerNodes: { type: Array, default: () => ["heading", "bulletList", "orderedList"] },
      writerHeadings: { type: Array, default: () => [2, 3, 4] },
      writerToolbar: { type: Object, default: () => ({ inline: false }) }
    },
    data() {
      return {
        current: this.parse(this.value),
        _updating: false
      };
    },
    watch: {
      value(v) {
        if (this._updating) return;
        this.current = this.parse(v);
      }
    },
    computed: {
      showModeSwitcher() {
        return this.writerModes.length >= 2;
      },
      translatedLabel() {
        return this.label || this.$t("pw.field.text");
      },
      // the dropdowns shown, in the order of the drawer: alignment, size
      // (with a preset), editor mode (with at least two)
      toolbarItems() {
        const items = [{ key: "align", value: this.current.align, options: this.alignOptions }];
        if (this.size && this.sizeOptions) items.push({ key: "size", value: this.current.size, options: this.sizeOptions });
        if (this.showModeSwitcher) items.push({ key: "mode", value: this.current.mode, options: this.writerModes });
        return items;
      },
      translatedHelp() {
        return this.fieldHelp || this.$t("pw.field.text-" + this.current.mode + ".help", "");
      },
      translatedPlaceholder() {
        return this.placeholder || this.$t("pw.field.text-" + this.current.mode + ".placeholder", "");
      }
    },
    methods: {
      parse(val) {
        const fallbackMode = this.defaultMode && this.writerModes.includes(this.defaultMode) ? this.defaultMode : this.writerModes[0] || "textarea";
        const base = { mode: fallbackMode, align: this.align, size: this.size, textarea: "", writer: "" };
        if (!val) return base;
        try {
          const d = JSON.parse(val);
          if (d && typeof d === "object" && d.mode) {
            const mode = this.writerModes.includes(d.mode) ? d.mode : fallbackMode;
            return {
              mode,
              align: d.align || this.align,
              size: d.size || this.size,
              textarea: d.textarea || "",
              writer: d.writer || ""
            };
          }
        } catch (e) {
        }
        const allowed = ["textarea", "writer"];
        return { ...base, mode: allowed.includes(val) ? val : "textarea" };
      },
      emit() {
        this._updating = true;
        this.$emit("input", JSON.stringify(this.current));
        this.$nextTick(() => {
          this._updating = false;
        });
      },
      // a dropdown chose a value (align, size or mode)
      setOption({ key, value }) {
        this.current = { ...this.current, [key]: value };
        this.emit();
      },
      onTextInput(e) {
        this.current = { ...this.current, [this.current.mode]: e.target.value };
        this.autoResize(e.target);
        this.emit();
      },
      onWriterInput(html) {
        this.current = { ...this.current, writer: html };
        this.emit();
      },
      autoResize(el) {
        el.style.height = "auto";
        el.style.height = el.scrollHeight + "px";
      }
    },
    mounted() {
      this.$nextTick(() => {
        const ta = this.$el.querySelector("textarea");
        if (ta) this.autoResize(ta);
      });
    },
    template: `
		<div class="k-field pw-editor-field">
			<header class="k-field-header" style="display:flex;align-items:center;overflow:visible;">
				<label class="k-label k-field-label" style="flex:1;">
					<span class="k-label-text">{{ translatedLabel }}</span>
				</label>
				<pw-field-toolbar :items="toolbarItems" @input="setOption" />
			</header>
			<div v-show="current.mode === 'textarea'" class="k-input pw-editor-textarea" data-type="textarea">
				<span class="k-input-element">
					<textarea
						:value="current.textarea"
						:placeholder="translatedPlaceholder"
						class="k-string-input k-textarea-input pw-textarea"
						@input="onTextInput"
					></textarea>
				</span>
			</div>
			<k-input
				v-if="current.mode === 'writer'"
				type="writer"
				:value="current.writer"
				:marks="writerMarks"
				:nodes="writerNodes"
				:headings="writerHeadings"
				:toolbar="writerToolbar"
				:placeholder="translatedPlaceholder"
				@input="onWriterInput"
			></k-input>
			<footer v-if="translatedHelp" class="k-field-footer">
				<div class="k-help k-field-help k-text" v-html="translatedHelp"></div>
			</footer>
		</div>
	`
  };
  const pwalign = {
    props: {
      value: String,
      align: { type: String, default: "left" },
      alignOptions: { type: Array, default: () => ["left", "center", "right"] },
      alwaysVisible: { type: Boolean, default: false }
    },
    data() {
      return {
        current: this.value || this.align,
        toolbar: null,
        container: null,
        _observer: null,
        _nextColumn: null
      };
    },
    watch: {
      value(v) {
        this.current = v || this.align;
        if (this.toolbar) this.toolbar.items = this.toolbarItems();
      }
    },
    mounted() {
      if (!this.value && this.current) {
        this.$emit("input", this.current);
      }
      this.$nextTick(() => {
        const wrapper = this.$el.closest(".k-column");
        if (wrapper) wrapper.style.display = "none";
        const nextColumn = wrapper == null ? void 0 : wrapper.nextElementSibling;
        const header = nextColumn == null ? void 0 : nextColumn.querySelector(".k-field-header");
        if (!header) return;
        this.container = document.createElement("span");
        this.container.className = "pw-align-btn";
        this.container.style.cssText = "position:relative;display:flex;align-items:center;";
        const Vue = this.$options._base;
        const self = this;
        this.toolbar = new Vue({
          parent: this,
          data: { items: this.toolbarItems() },
          render(h) {
            return h(pwFieldToolbar, {
              props: { items: this.items },
              on: { input: ({ value }) => self.select(value) }
            });
          }
        }).$mount();
        this.container.appendChild(this.toolbar.$el);
        const existingBtn = header.querySelector(".k-button");
        if (existingBtn && existingBtn.parentElement !== header) {
          existingBtn.parentElement.prepend(this.container);
        } else if (existingBtn) {
          header.insertBefore(this.container, existingBtn);
        } else {
          header.appendChild(this.container);
        }
        this._nextColumn = nextColumn;
        this.updateVisibility();
        this._observer = new MutationObserver(() => this.updateVisibility());
        this._observer.observe(nextColumn, { childList: true, subtree: true });
      });
    },
    methods: {
      updateVisibility() {
        if (!this.container || !this._nextColumn) return;
        if (this.alwaysVisible) {
          this.container.style.display = "flex";
          return;
        }
        const hasItems = this._nextColumn.querySelector(".k-item, .k-block, .k-structure-item") !== null;
        this.container.style.display = hasItems ? "flex" : "none";
      },
      toolbarItems() {
        return [{ key: "align", value: this.current || "left", options: this.alignOptions }];
      },
      select(opt) {
        this.current = opt;
        if (this.toolbar) this.toolbar.items = this.toolbarItems();
        this.$emit("input", opt);
      }
    },
    beforeDestroy() {
      if (this._observer) this._observer.disconnect();
      if (this.toolbar) this.toolbar.$destroy();
      if (this.container) this.container.remove();
    },
    template: '<div style="display:none"></div>'
  };
  const pwicon = {
    props: {
      value: String,
      label: String,
      help: String,
      disabled: Boolean
    },
    data() {
      return {
        current: this.value || "",
        icons: [],
        search: "",
        setName: ""
      };
    },
    watch: {
      value(v) {
        this.current = v || "";
      }
    },
    computed: {
      filtered() {
        const q = this.search.trim().toLowerCase();
        if (!q) return [];
        return this.icons.filter((i) => i.id.toLowerCase().includes(q));
      },
      selectedIcon() {
        if (!this.current) return null;
        return this.icons.find((i) => i.svg === this.current) || null;
      },
      showCount() {
        return this.search.trim() ? this.filtered.length : this.icons.length;
      }
    },
    async created() {
      try {
        const config = await this.$api.get("pagewizard/config");
        const activeSet = config["icon-set"];
        this.setName = config["icon-set-name"] || activeSet;
        const res = await this.$api.get("pagewizard/icons/" + activeSet);
        this.icons = Array.isArray(res) ? res : [];
      } catch (e) {
        this.icons = [];
      }
    },
    methods: {
      select(icon) {
        if (this.disabled) return;
        this.current = icon ? icon.svg : "";
        this.$emit("input", this.current);
      },
      clear() {
        if (this.disabled) return;
        this.current = "";
        this.$emit("input", "");
      },
      isActive(icon) {
        return this.current === icon.svg;
      }
    },
    template: `
		<k-field v-bind="$props" class="pw-icon-field">
			<div class="pw-icon-search">
				<div class="pw-icon-input-wrap">
					<span class="pw-icon-search-icon"><k-icon type="search" /></span>
					<k-input
						type="text"
						:placeholder="$t('pw.field.icon.placeholder')"
						:value="search"
						@input="search = $event"
					/>
					<span class="pw-icon-count">{{ showCount }} {{ showCount === 1 ? $t('pw.icon.count.one') : $t('pw.icon.count.other') }}</span>
				</div>
				<button
					v-if="current"
					type="button"
					class="pw-icon-preview"
					:title="selectedIcon ? selectedIcon.label : ''"
					:disabled="disabled"
					@click="clear()"
				><span v-html="current"></span></button>
			</div>
			<div class="k-help k-field-help k-text" style="margin-top: var(--spacing-2); margin-bottom: var(--spacing-8)"><p v-html="$t('pw.field.icon.help', { total: icons.length, set: setName })"></p></div>
			<div class="pw-icon-grid">
				<button
					v-for="icon in filtered"
					:key="icon.id"
					type="button"
					class="pw-icon-btn"
					:class="{ 'is-active': isActive(icon), 'is-custom': icon.custom }"
					:disabled="disabled"
					:title="icon.label"
					@click="select(icon)"
				><span v-html="icon.svg"></span></button>
			</div>
		</k-field>
	`
  };
  const pwsharedname = {
    extends: "k-text-field",
    mounted() {
      this.$nextTick(() => {
        var _a, _b;
        const endpoint = ((_a = this.endpoints) == null ? void 0 : _a.field) || "";
        const isSharedContext = endpoint.includes("/sharedblocks/");
        if (!isSharedContext) {
          if (this.$el) {
            this.$el.style.display = "none";
            const col = this.$el.closest(".k-column");
            if (col) col.style.display = "none";
          }
          return;
        }
        const myCol = (_b = this.$el) == null ? void 0 : _b.closest(".k-column");
        const fragmentCol = myCol == null ? void 0 : myCol.nextElementSibling;
        if (fragmentCol) fragmentCol.style.display = "none";
        const d = /* @__PURE__ */ new Date();
        const pad = (n) => String(n).padStart(2, "0");
        const generated = `${d.getFullYear()}-${pad(d.getMonth() + 1)}-${pad(d.getDate())} ${pad(d.getHours())}:${pad(d.getMinutes())}:${pad(d.getSeconds())}`;
        if (!this.value) {
          this.$emit("input", generated);
          setTimeout(() => {
            var _a2;
            const input = (_a2 = this.$el) == null ? void 0 : _a2.querySelector("input");
            if (!input) return;
            input.style.color = "var(--color-gray-500, #999)";
            input.addEventListener("focus", () => {
              input.style.color = "";
              input.value = "";
              this.$emit("input", "");
            }, { once: true });
          }, 0);
        }
      });
    }
  };
  const FROM_DEVICE = { xl: "xl", lg: "lg", default: "sm" };
  const deviceSize = () => FROM_DEVICE[document.documentElement.dataset.pwDevice] || "xl";
  const _sfc_main$1 = {
    inheritAttrs: false,
    props: {
      label: String,
      help: String,
      // which rows: columns (columnssm …), grid (gridsize…/gridoffset…), logos (logossm …)
      group: { type: String, default: "columns" }
    },
    data() {
      return { sizes: ["sm", "md", "lg", "xl"], bp: deviceSize() };
    },
    mounted() {
      this.mark();
      this._observer = new MutationObserver(() => this.choose(deviceSize()));
      this._observer.observe(document.documentElement, { attributes: true, attributeFilter: ["data-pw-device"] });
    },
    beforeDestroy() {
      if (this._observer) this._observer.disconnect();
      const scope = this.scope();
      if (scope) scope.removeAttribute("data-pw-bp-" + this.group);
    },
    methods: {
      // the rows shown: set on the drawer (or the form) around the field
      scope() {
        return this.$el.closest(".k-drawer") || this.$el.closest(".k-fieldset");
      },
      mark() {
        const scope = this.scope();
        if (scope) scope.setAttribute("data-pw-bp-" + this.group, this.bp);
      },
      choose(b) {
        this.bp = b;
        this.mark();
      }
    }
  };
  var _sfc_render$1 = function render() {
    var _vm = this, _c = _vm._self._c;
    return _c("div", { class: ["k-headline-field", "pw-breakpoints-field", _vm.$attrs.class], style: _vm.$attrs.style }, [_c("div", { staticClass: "pw-breakpoints-head" }, [_c("k-headline", { staticClass: "h2" }, [_vm._v(_vm._s(_vm.label))]), _c("span", { staticClass: "pw-breakpoints-pills", attrs: { "role": "group" } }, _vm._l(_vm.sizes, function(b) {
      return _c("button", { key: b, attrs: { "type": "button", "aria-pressed": _vm.bp === b ? "true" : "false" }, on: { "click": function($event) {
        return _vm.choose(b);
      } } }, [_vm._v(_vm._s(b.toUpperCase()))]);
    }), 0)], 1), _vm.help ? _c("footer", { staticClass: "k-field-footer" }, [_c("k-text", { staticClass: "k-help k-field-help", attrs: { "html": _vm.help } })], 1) : _vm._e()]);
  };
  var _sfc_staticRenderFns$1 = [];
  _sfc_render$1._withStripped = true;
  var __component__$1 = /* @__PURE__ */ normalizeComponent(
    _sfc_main$1,
    _sfc_render$1,
    _sfc_staticRenderFns$1,
    false,
    null,
    null
  );
  __component__$1.options.__file = "/Users/christian/Projects/pluginsources/kirby-pagewizard/src/fields/pwbreakpoints.vue";
  const pwbreakpoints = __component__$1.exports;
  const _sfc_main = {
    data() {
      return {
        sets: [],
        activeSet: null,
        icons: [],
        search: "",
        copied: null
      };
    },
    computed: {
      filtered() {
        const q = this.search.trim().toLowerCase();
        if (!q) return this.icons;
        return this.icons.filter((i) => i.id.toLowerCase().includes(q));
      }
    },
    async created() {
      try {
        this.sets = await this.$api.get("pagewizard/icons/sets");
        if (this.sets.length) {
          const preferred = this.sets.find((s) => s !== "custom") || this.sets[0];
          await this.loadSet(preferred);
        }
      } catch (e) {
      }
    },
    methods: {
      async loadSet(set) {
        this.activeSet = set;
        this.search = "";
        try {
          const res = await this.$api.get("pagewizard/icons/" + set);
          this.icons = Array.isArray(res) ? res : [];
        } catch (e) {
          this.icons = [];
        }
      },
      async copy(id) {
        try {
          await navigator.clipboard.writeText(id);
          this.copied = id;
          setTimeout(() => {
            this.copied = null;
          }, 2e3);
        } catch (e) {
        }
      }
    }
  };
  var _sfc_render = function render() {
    var _vm = this, _c = _vm._self._c;
    return _c("k-panel-inside", { staticClass: "pw-icons-view" }, [_c("k-header", { scopedSlots: _vm._u([{ key: "right", fn: function() {
      return [_c("k-button-group", _vm._l(_vm.sets, function(s) {
        return _c("k-button", { key: s, attrs: { "text": s, "theme": _vm.activeSet === s ? "positive" : null, "variant": "filled", "size": "sm" }, on: { "click": function($event) {
          return _vm.loadSet(s);
        } } });
      }), 1)];
    }, proxy: true }]) }, [_vm._v(" " + _vm._s(_vm.$t("pw.icon.reference")) + " ")]), _c("div", { staticClass: "pw-icons-search" }, [_c("k-input", { attrs: { "type": "text", "placeholder": _vm.$t("pw.icon.search"), "value": _vm.search }, on: { "input": function($event) {
      _vm.search = $event;
    } } }), _c("span", { staticClass: "pw-icons-count" }, [_vm._v(_vm._s(_vm.filtered.length) + " / " + _vm._s(_vm.icons.length))])], 1), _c("div", { staticClass: "pw-icons-grid" }, _vm._l(_vm.filtered, function(icon) {
      return _c("button", { key: icon.id, staticClass: "pw-icons-item", class: { "is-custom": icon.custom }, attrs: { "title": icon.id }, on: { "click": function($event) {
        return _vm.copy(icon.id);
      } } }, [_c("span", { staticClass: "pw-icons-svg", domProps: { "innerHTML": _vm._s(icon.svg) } }), _c("span", { staticClass: "pw-icons-label" }, [_vm._v(_vm._s(icon.id))])]);
    }), 0), _vm.copied ? _c("k-notification", { attrs: { "theme": "positive", "type": "alert" } }, [_vm._v(' "' + _vm._s(_vm.copied) + '" ' + _vm._s(_vm.$t("pw.icon.copied")) + " ")]) : _vm._e()], 1);
  };
  var _sfc_staticRenderFns = [];
  _sfc_render._withStripped = true;
  var __component__ = /* @__PURE__ */ normalizeComponent(
    _sfc_main,
    _sfc_render,
    _sfc_staticRenderFns,
    false,
    null,
    null
  );
  __component__.options.__file = "/Users/christian/Projects/pluginsources/kirby-pagewizard/src/views/icons.vue";
  const iconsView = __component__.exports;
  panel.plugin("kirbydesk/kirby-pagewizard", {
    created() {
      if (!("BroadcastChannel" in window)) return;
      const bc = new BroadcastChannel(panel.urls.site);
      panel.events.on("model.update", () => {
        bc.postMessage("content/saved");
      });
    },
    blocks: {
      pwButton,
      pwButtons,
      pwFooter,
      pwFooterItem,
      pwshared
    },
    fields: {
      // the pages' blocks field: Kirby's own (the Project Wizard adds to it)
      pwblocks: { extends: "k-blocks-field" },
      htmlheadline,
      pwtext,
      pweditor,
      pwalign,
      pwicon,
      pwsharedname,
      pwbreakpoints
    },
    components: {
      "pw-icons-view": iconsView,
      // the dropdowns of a content field (also used by the Project Wizard)
      "pw-field-toolbar": pwFieldToolbar,
      // an option of a content field as icon or text (also used by the Project Wizard)
      "pw-option-icon": pwOptionIcon
    },
    icons: {
      "pw-level-div": '<path d="M13 6V21H11V6H5V4H19V6H13Z"/>',
      "align-left": '<path transform="rotate(-90 12 12)" d="M3 3H21V5H3V3ZM8 11V21H6V11H3L7 7L11 11H8ZM18 11V21H16V11H13L17 7L21 11H18Z"/>',
      "align-right": '<path transform="rotate(90 12 12)" d="M3 3H21V5H3V3ZM8 11V21H6V11H3L7 7L11 11H8ZM18 11V21H16V11H13L17 7L21 11H18Z"/>',
      "cardlets": '<path d="M3 4C3 3.44772 3.44772 3 4 3H10C10.5523 3 11 3.44772 11 4V10C11 10.5523 10.5523 11 10 11H4C3.44772 11 3 10.5523 3 10V4ZM3 14C3 13.4477 3.44772 13 4 13H10C10.5523 13 11 13.4477 11 14V20C11 20.5523 10.5523 21 10 21H4C3.44772 21 3 20.5523 3 20V14ZM13 4C13 3.44772 13.4477 3 14 3H20C20.5523 3 21 3.44772 21 4V10C21 10.5523 20.5523 11 20 11H14C13.4477 11 13 10.5523 13 10V4ZM13 14C13 13.4477 13.4477 13 14 13H20C20.5523 13 21 13.4477 21 14V20C21 20.5523 20.5523 21 20 21H14C13.4477 21 13 20.5523 13 20V14ZM15 5V9H19V5H15ZM15 15V19H19V15H15ZM5 5V9H9V5H5ZM5 15V19H9V15H5Z"/>',
      "customradius": '<path d="M8 3V5H4V9H2V3H8ZM2 21V15H4V19H8V21H2ZM22 21H16V19H20V15H22V21ZM22 9H20V5H16V3H22V9Z"/>',
      "definitionlist": '<path d="M8 4H21V6H8V4ZM3 3.5H6V6.5H3V3.5ZM3 10.5H6V13.5H3V10.5ZM3 17.5H6V20.5H3V17.5ZM8 11H21V13H8V11ZM8 18H21V20H8V18Z"/>',
      "editor-mode": '<path d="M16.7574 2.99678L14.7574 4.99678H5V18.9968H19V9.23943L21 7.23943V19.9968C21 20.5491 20.5523 20.9968 20 20.9968H4C3.44772 20.9968 3 20.5491 3 19.9968V3.99678C3 3.4445 3.44772 2.99678 4 2.99678H16.7574ZM20.4853 2.09729L21.8995 3.5115L12.7071 12.7039L11.2954 12.7064L11.2929 11.2897L20.4853 2.09729Z"/>',
      "expand-left": '<path d="M10.071 4.92896L11.4852 6.34317L6.82834 11L16.0002 11.0002L16.0002 13.0002L6.82839 13L11.4852 17.6569L10.071 19.0711L2.99994 12L10.071 4.92896ZM18.0001 19V4.99997H20.0001V19H18.0001Z"/>',
      "expand-left-right": '<path d="M7.44975 7.05029L2.5 12L7.44727 16.9473L8.86148 15.5331L6.32843 13H17.6708L15.1358 15.535L16.55 16.9493L21.5 11.9996L16.5503 7.0498L15.136 8.46402L17.6721 11H6.32843L8.86396 8.46451L7.44975 7.05029Z"/>',
      "expand-right": '<path d="M17.1717 11L12.5148 6.34317L13.929 4.92896L21.0001 12L13.929 19.0711L12.5148 17.6569L17.1716 13L7.9998 13.0002L7.99978 11.0002L17.1717 11ZM3.99985 19L3.99985 4.99997H5.99985V19H3.99985Z"/>',
      "expand-width": '<path d="M2 6L2 18H4L4 6H2ZM9.44975 7.05025L4.5 12L9.44727 16.9473L9.44826 13H14.5501L14.55 16.9492L19.5 11.9995L14.5503 7.04976L14.5502 11H9.44876L9.44975 7.05025ZM20 6H22V18H20V6Z"/>',
      "faq": '<path d="M5.45455 15L1 18.5V3C1 2.44772 1.44772 2 2 2H17C17.5523 2 18 2.44772 18 3V15H5.45455ZM4.76282 13H16V4H3V14.3851L4.76282 13ZM8 17H18.2372L20 18.3851V8H21C21.5523 8 22 8.44772 22 9V22.5L17.5455 19H9C8.44772 19 8 18.5523 8 18V17Z"/>',
      "featurelist": '<path d="M13 4H21V6H13V4ZM13 11H21V13H13V11ZM13 18H21V20H13V18ZM6.5 19C5.39543 19 4.5 18.1046 4.5 17C4.5 15.8954 5.39543 15 6.5 15C7.60457 15 8.5 15.8954 8.5 17C8.5 18.1046 7.60457 19 6.5 19ZM6.5 21C8.70914 21 10.5 19.2091 10.5 17C10.5 14.7909 8.70914 13 6.5 13C4.29086 13 2.5 14.7909 2.5 17C2.5 19.2091 4.29086 21 6.5 21ZM5 6V9H8V6H5ZM3 4H10V11H3V4Z"/>',
      "item": '<path d="M4 3H20C20.5523 3 21 3.44772 21 4V20C21 20.5523 20.5523 21 20 21H4C3.44772 21 3 20.5523 3 20V4C3 3.44772 3.44772 3 4 3ZM5 5V19H19V5H5ZM11.0026 16L6.75999 11.7574L8.17421 10.3431L11.0026 13.1716L16.6595 7.51472L18.0737 8.92893L11.0026 16Z"/>',
      "legal": '<path d="M12.9985 2L12.9979 3.278L17.9985 4.94591L21.631 3.73509L22.2634 5.63246L19.2319 6.643L22.3272 15.1549C21.2353 16.2921 19.6996 17 17.9985 17C16.2975 17 14.7618 16.2921 13.6699 15.1549L16.7639 6.643L12.9979 5.387V19H16.9985V21H6.99854V19H10.9979V5.387L7.23192 6.643L10.3272 15.1549C9.23528 16.2921 7.69957 17 5.99854 17C4.2975 17 2.76179 16.2921 1.66992 15.1549L4.76392 6.643L1.73363 5.63246L2.36608 3.73509L5.99854 4.94591L10.9979 3.278L10.9985 2H12.9985ZM17.9985 9.10267L16.04 14.4892C16.628 14.8201 17.2979 15 17.9985 15C18.6992 15 19.3691 14.8201 19.957 14.4892L17.9985 9.10267ZM5.99854 9.10267L4.04004 14.4892C4.62795 14.8201 5.29792 15 5.99854 15C6.69916 15 7.36912 14.8201 7.95703 14.4892L5.99854 9.10267Z"/>',
      "shared-block": '<path d="M12 2.58582L18.2071 8.79292L16.7929 10.2071L13 6.41424V16H11V6.41424L7.20711 10.2071L5.79289 8.79292L12 2.58582ZM3 18V14H5V18C5 18.5523 5.44772 19 6 19H18C18.5523 19 19 18.5523 19 18V14H21V18C21 19.6569 19.6569 21 18 21H6C4.34315 21 3 19.6569 3 18Z"/>',
      "textsize-large": '<path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z"/>',
      "textsize-normal": '<path d="M10 6V21H8V6H2V4H16V6H10ZM18 14V21H16V14H13V12H21V14H18Z"/>',
      "textsize-xlarge": '<path d="M13.0001 10.9999L22.0002 10.9997L22.0002 12.9997L13.0001 12.9999L13.0001 21.9998L11.0001 21.9998L11.0001 12.9999L2.00004 13.0001L2 11.0001L11.0001 10.9999L11 2.00025L13 2.00024L13.0001 10.9999Z"/>',
      "pw-deco-none": '<line x1="6" y1="12" x2="18" y2="12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>',
      "pw-deco-underline": '<path d="M5 4v8a7 7 0 0 0 14 0V4M5 20h14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>',
      "pw-deco-arrow": '<path d="M5 12h14M13 5l7 7-7 7" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>',
      "pw-deco-long-arrow": '<path d="M2 12h19m-5-5l5 5-5 5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>',
      "pw-deco-chevron": '<polyline points="9 6 15 12 9 18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>',
      "pw-deco-caret": '<path d="M8 5l8 7-8 7z" fill="currentColor"/>'
    }
  });
})();
