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
  const _sfc_main$3 = {};
  var _sfc_render$3 = function render() {
    var _vm = this, _c = _vm._self._c;
    return _c("div", { staticClass: "pwPreview", on: { "dblclick": _vm.open } }, [_vm.content.name ? _c("div", { staticClass: "heading" }, [_vm._v(" " + _vm._s(_vm.content.name) + " ")]) : _c("div", { staticClass: "heading placeholder" }, [_vm._v(" " + _vm._s(_vm.$t("pw.footer.name")) + " ... ")]), _vm._l(_vm.content.blocks, function(item) {
      return _c("div", { key: item.id, staticClass: "items" }, [_c("div", { staticClass: "linktext", class: { placeholder: !item.content.linktext } }, [_c("span", [_vm._v(_vm._s(item.content.linktext || _vm.$t("pw.field.link-text.placeholder")))]), item.content.linktarget ? _c("span", { staticClass: "k-icon" }, [_c("k-icon", { attrs: { "type": "open" } })], 1) : _vm._e()])]);
    })], 2);
  };
  var _sfc_staticRenderFns$3 = [];
  _sfc_render$3._withStripped = true;
  var __component__$3 = /* @__PURE__ */ normalizeComponent(
    _sfc_main$3,
    _sfc_render$3,
    _sfc_staticRenderFns$3,
    false,
    null,
    "40650bd6"
  );
  __component__$3.options.__file = "/Users/christian/Projects/kirbydesk/site/plugins/kirby-pagewizard/src/blocks/footer/index.vue";
  const pwFooter = __component__$3.exports;
  const _sfc_main$2 = {};
  var _sfc_render$2 = function render() {
    var _vm = this, _c = _vm._self._c;
    return _c("div", { staticClass: "pwPreview", on: { "dblclick": _vm.open } }, [_vm.content.linktext ? _c("div", { staticClass: "linktext" }, [_c("span", [_vm._v(_vm._s(_vm.content.linktext))]), _vm.content.linktarget ? _c("span", { staticClass: "k-icon" }, [_c("k-icon", { attrs: { "type": "open" } })], 1) : _vm._e()]) : _c("div", { staticClass: "placeholder" }, [_vm._v(" " + _vm._s(_vm.$t("pw.field.link-text.placeholder")) + " ")])]);
  };
  var _sfc_staticRenderFns$2 = [];
  _sfc_render$2._withStripped = true;
  var __component__$2 = /* @__PURE__ */ normalizeComponent(
    _sfc_main$2,
    _sfc_render$2,
    _sfc_staticRenderFns$2,
    false,
    null,
    "f57ea2ba"
  );
  __component__$2.options.__file = "/Users/christian/Projects/kirbydesk/site/plugins/kirby-pagewizard/src/blocks/footer/item.vue";
  const pwFooterItem = __component__$2.exports;
  const _sfc_main$1 = {};
  var _sfc_render$1 = function render() {
    var _vm = this, _c = _vm._self._c;
    _vm._self._setupProxy;
    return _c("div", { on: { "dblclick": _vm.open } }, [_c("button", { staticClass: "k-button", attrs: { "data-has-text": "true", "data-responsive": "true", "data-size": "sm", "data-variant": "filled", "type": "button" } }, [_vm.content.linktext.length ? _c("span", { staticClass: "k-button-text", domProps: { "innerHTML": _vm._s(_vm.content.linktext) }, on: { "blur": function($event) {
      return _vm.update({ linktext: $event.target.innerText });
    } } }) : _c("span", { staticClass: "k-button-text placeholder" }, [_vm._v(" " + _vm._s(_vm.$t("pw.field.link-text.placeholder")) + " ")])])]);
  };
  var _sfc_staticRenderFns$1 = [];
  _sfc_render$1._withStripped = true;
  var __component__$1 = /* @__PURE__ */ normalizeComponent(
    _sfc_main$1,
    _sfc_render$1,
    _sfc_staticRenderFns$1,
    false,
    null,
    "10e849d1"
  );
  __component__$1.options.__file = "/Users/christian/Projects/kirbydesk/site/plugins/kirby-pagewizard/src/components/button.vue";
  const pwButton = __component__$1.exports;
  const _sfc_main = {
    props: {
      value: String
    }
  };
  var _sfc_render = function render() {
    var _vm = this, _c = _vm._self._c;
    return _vm.value && _vm.value.length ? _c("div", { staticClass: "k-button-group" }, _vm._l(_vm.value, function(item) {
      return _c("div", { key: item.id, class: { "ishidden": item.isHidden } }, [_c("button", { staticClass: "k-button", attrs: { "type": "button", "data-has-text": "true", "data-responsive": "true", "data-size": "md", "data-variant": "filled" } }, [item.content.linktext.length ? _c("span", { staticClass: "k-button-text" }, [_vm._v(" " + _vm._s(item.content.linktext) + " ")]) : _c("span", { staticClass: "k-button-text placeholder" }, [_vm._v(" " + _vm._s(_vm.$t("pw.field.link-text.placeholder")) + " ")])])]);
    }), 0) : _vm._e();
  };
  var _sfc_staticRenderFns = [];
  _sfc_render._withStripped = true;
  var __component__ = /* @__PURE__ */ normalizeComponent(
    _sfc_main,
    _sfc_render,
    _sfc_staticRenderFns,
    false,
    null,
    "a81c040e"
  );
  __component__.options.__file = "/Users/christian/Projects/kirbydesk/site/plugins/kirby-pagewizard/src/components/buttons.vue";
  const pwButtons = __component__.exports;
  panel.plugin("kirbydesk/kirby-pagewizard", {
    blocks: {
      pwButton,
      pwButtons,
      pwFooter,
      pwFooterItem
    },
    icons: {
      "expand-left": '<path d="M10.071 4.92896L11.4852 6.34317L6.82834 11L16.0002 11.0002L16.0002 13.0002L6.82839 13L11.4852 17.6569L10.071 19.0711L2.99994 12L10.071 4.92896ZM18.0001 19V4.99997H20.0001V19H18.0001Z"/>',
      "expand-right": '<path d="M17.1717 11L12.5148 6.34317L13.929 4.92896L21.0001 12L13.929 19.0711L12.5148 17.6569L17.1716 13L7.9998 13.0002L7.99978 11.0002L17.1717 11ZM3.99985 19L3.99985 4.99997H5.99985V19H3.99985Z"/>',
      "expand-left-right": '<path d="M7.44975 7.05029L2.5 12L7.44727 16.9473L8.86148 15.5331L6.32843 13H17.6708L15.1358 15.535L16.55 16.9493L21.5 11.9996L16.5503 7.0498L15.136 8.46402L17.6721 11H6.32843L8.86396 8.46451L7.44975 7.05029Z"/>',
      "expand-width": '<path d="M2 6L2 18H4L4 6H2ZM9.44975 7.05025L4.5 12L9.44727 16.9473L9.44826 13H14.5501L14.55 16.9492L19.5 11.9995L14.5503 7.04976L14.5502 11H9.44876L9.44975 7.05025ZM20 6H22V18H20V6Z"/>'
    }
  });
})();
