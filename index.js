(function() {
  "use strict";
  function normalizeComponent(scriptExports, render, staticRenderFns, functionalTemplate, injectStyles, scopeId, moduleIdentifier, shadowMode) {
    var options = typeof scriptExports === "function" ? scriptExports.options : scriptExports;
    if (render) {
      options.render = render;
      options.staticRenderFns = staticRenderFns;
      options._compiled = true;
    }
    return {
      exports: scriptExports,
      options
    };
  }
  const _sfc_main$1 = {};
  var _sfc_render$1 = function render() {
    var _vm = this, _c = _vm._self._c;
    return _c("div", { staticClass: "pwPreview", on: { "dblclick": _vm.open } }, [_vm.content.name ? _c("div", { staticClass: "heading" }, [_vm._v(" " + _vm._s(_vm.content.name) + " ")]) : _c("div", { staticClass: "heading placeholder" }, [_vm._v(" " + _vm._s(_vm.$t("pw.footer.name")) + " ... ")]), _vm._l(_vm.content.blocks, function(item) {
      return _c("div", { key: item.id, staticClass: "items" }, [_c("div", { class: { placeholder: !item.content.linktext } }, [_vm._v(" " + _vm._s(item.content.linktext || _vm.$t("pw.field.link-text.placeholder")) + " ")])]);
    })], 2);
  };
  var _sfc_staticRenderFns$1 = [];
  _sfc_render$1._withStripped = true;
  var __component__$1 = /* @__PURE__ */ normalizeComponent(
    _sfc_main$1,
    _sfc_render$1,
    _sfc_staticRenderFns$1
  );
  __component__$1.options.__file = "/Users/christian/Projects/kirbydesk/site/plugins/kirby-pagewizard/src/blocks/footer/index.vue";
  const footer = __component__$1.exports;
  const _sfc_main = {};
  var _sfc_render = function render() {
    var _vm = this, _c = _vm._self._c;
    return _c("div", { staticClass: "pwPreview", on: { "dblclick": _vm.open } }, [_vm.content.linktext ? _c("div", [_vm._v(" " + _vm._s(_vm.content.linktext) + " ")]) : _c("div", { staticClass: "placeholder" }, [_vm._v(" " + _vm._s(_vm.$t("pw.field.link-text.placeholder")) + " ")])]);
  };
  var _sfc_staticRenderFns = [];
  _sfc_render._withStripped = true;
  var __component__ = /* @__PURE__ */ normalizeComponent(
    _sfc_main,
    _sfc_render,
    _sfc_staticRenderFns
  );
  __component__.options.__file = "/Users/christian/Projects/kirbydesk/site/plugins/kirby-pagewizard/src/blocks/footer/item.vue";
  const footerItem = __component__.exports;
  panel.plugin("kirbydesk/kirby-pagewizard", {
    blocks: {
      footer,
      footerItem
    }
  });
})();
