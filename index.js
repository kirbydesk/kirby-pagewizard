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
      "expand-width": '<path d="M2 6L2 18H4L4 6H2ZM9.44975 7.05025L4.5 12L9.44727 16.9473L9.44826 13H14.5501L14.55 16.9492L19.5 11.9995L14.5503 7.04976L14.5502 11H9.44876L9.44975 7.05025ZM20 6H22V18H20V6Z"/>',
      "legal": '<path d="M12.9985 2L12.9979 3.278L17.9985 4.94591L21.631 3.73509L22.2634 5.63246L19.2319 6.643L22.3272 15.1549C21.2353 16.2921 19.6996 17 17.9985 17C16.2975 17 14.7618 16.2921 13.6699 15.1549L16.7639 6.643L12.9979 5.387V19H16.9985V21H6.99854V19H10.9979V5.387L7.23192 6.643L10.3272 15.1549C9.23528 16.2921 7.69957 17 5.99854 17C4.2975 17 2.76179 16.2921 1.66992 15.1549L4.76392 6.643L1.73363 5.63246L2.36608 3.73509L5.99854 4.94591L10.9979 3.278L10.9985 2H12.9985ZM17.9985 9.10267L16.04 14.4892C16.628 14.8201 17.2979 15 17.9985 15C18.6992 15 19.3691 14.8201 19.957 14.4892L17.9985 9.10267ZM5.99854 9.10267L4.04004 14.4892C4.62795 14.8201 5.29792 15 5.99854 15C6.69916 15 7.36912 14.8201 7.95703 14.4892L5.99854 9.10267Z"/>'
    },
    fields: {
      htmlheadline: {
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
      },
      pwtext: {
        extends: "k-text-field",
        props: {
          label: String,
          help: String,
          placeholder: String,
          value: String,
          align: String,
          level: String,
          alignOptions: {
            type: Array,
            default: () => ["left", "center", "right"]
          },
          levelOptions: {
            type: Array,
            default: () => ["h1", "h2", "h3", "h4"]
          }
        },
        data() {
          return {
            currentAlign: this.parseValue().align || (this.align || "left"),
            currentLevel: this.parseValue().level || (this.level || "h2"),
            showAlignDropdown: false,
            showLevelDropdown: false
          };
        },
        watch: {
          value(newValue) {
            const parsed = this.parseValue();
            if (parsed.align) this.currentAlign = parsed.align;
            if (parsed.level) this.currentLevel = parsed.level;
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
          emitValue(text, align, level) {
            const data = {
              text,
              align,
              level
            };
            this.$emit("input", JSON.stringify(data));
          },
          updateAlign(value) {
            this.currentAlign = value;
            this.showAlignDropdown = false;
            const parsed = this.parseValue();
            this.emitValue(parsed.text || "", value, parsed.level || this.currentLevel);
          },
          updateLevel(value) {
            this.currentLevel = value;
            this.showLevelDropdown = false;
            const parsed = this.parseValue();
            this.emitValue(parsed.text || "", parsed.align || this.currentAlign, value);
          },
          handleInput(event) {
            this.emitValue(event.target.value, this.currentAlign, this.currentLevel);
          },
          closeDropdowns() {
            this.showAlignDropdown = false;
            this.showLevelDropdown = false;
          },
          toggleLevelDropdown() {
            this.showAlignDropdown = false;
            this.showLevelDropdown = !this.showLevelDropdown;
          },
          toggleAlignDropdown() {
            this.showLevelDropdown = false;
            this.showAlignDropdown = !this.showAlignDropdown;
          },
          handleClickOutside(event) {
            if (!this.$el.contains(event.target)) {
              this.closeDropdowns();
            }
          },
          handleEscape(event) {
            if (event.key === "Escape") {
              if (this.showAlignDropdown || this.showLevelDropdown) {
                event.stopPropagation();
                event.preventDefault();
                this.closeDropdowns();
              }
            }
          }
        },
        mounted() {
          this.$nextTick(() => {
            document.addEventListener("click", this.handleClickOutside, true);
            document.addEventListener("keydown", this.handleEscape);
          });
        },
        beforeDestroy() {
          document.removeEventListener("click", this.handleClickOutside, true);
          document.removeEventListener("keydown", this.handleEscape);
        },
        template: `
        <div class="k-field k-text-field" :data-align="currentAlign" :data-level="currentLevel">
					<header v-if="label" class="k-field-header">
						<label class="k-label k-field-label">
							<span class="k-label-text">{{ label }}</span>
						</label>
					</header>
					<div class="k-input" data-type="text">
						<span class="k-input-element">
							<input
								:value="parseValue().text || ''"
								@input="handleInput"
								:placeholder="placeholder"
								type="text"
								class="k-string-input k-text-input"
							/>
						</span>
						<span v-if="level" class="k-input-icon" @click.stop="toggleLevelDropdown">
							<svg aria-hidden="true" :data-type="currentLevel" class="k-icon">
								<use :xlink:href="'#icon-' + currentLevel"></use>
							</svg>
							<dialog v-if="showLevelDropdown" class="k-dropdown-content pw-dropdown" data-theme="dark" open>
								<div class="k-navigate">
									<button
										v-for="option in levelOptions"
										:key="option"
										@click.stop="updateLevel(option)"
										type="button"
										class="k-button k-dropdown-item"
										data-has-icon="true"
									>
										<span class="k-button-icon">
											<svg class="k-icon"><use :xlink:href="'#icon-' + option"></use></svg>
										</span>
									</button>
								</div>
							</dialog>
						</span>
						<span v-if="align" class="k-input-icon" @click.stop="toggleAlignDropdown">
							<svg aria-hidden="true" :data-type="'text-' + currentAlign" class="k-icon">
								<use :xlink:href="'#icon-text-' + currentAlign"></use>
							</svg>
							<dialog v-if="showAlignDropdown" class="k-dropdown-content pw-dropdown" data-theme="dark" open>
								<div class="k-navigate">
									<button
										v-for="option in alignOptions"
										:key="option"
										@click.stop="updateAlign(option)"
										type="button"
										class="k-button k-dropdown-item"
										data-has-icon="true"
									>
										<span class="k-button-icon">
											<svg class="k-icon"><use :xlink:href="'#icon-text-' + option"></use></svg>
										</span>
									</button>
								</div>
							</dialog>
						</span>
					</div>
					<footer v-if="help" class="k-field-footer">
						<div class="k-help k-field-help k-text" v-html="help"></div>
					</footer>
				</div>
      `
      },
      pwtextarea: {
        extends: "k-textarea-field",
        props: {
          label: String,
          help: String,
          placeholder: String,
          value: String,
          align: String,
          alignOptions: {
            type: Array,
            default: () => ["left", "center", "right"]
          }
        },
        data() {
          return {
            currentAlign: this.parseValue().align || (this.align || "left"),
            showAlignDropdown: false
          };
        },
        watch: {
          value(newValue) {
            const parsed = this.parseValue();
            if (parsed.align) this.currentAlign = parsed.align;
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
          emitValue(text, align) {
            const data = {
              text,
              align
            };
            this.$emit("input", JSON.stringify(data));
          },
          updateAlign(value) {
            this.currentAlign = value;
            this.showAlignDropdown = false;
            const parsed = this.parseValue();
            this.emitValue(parsed.text || "", value);
          },
          handleInput(event) {
            this.autoResize(event.target);
            this.emitValue(event.target.value, this.currentAlign);
          },
          autoResize(textarea) {
            textarea.style.height = "auto";
            const newHeight = textarea.scrollHeight;
            textarea.style.height = newHeight + "px";
            textarea.style.minHeight = newHeight + "px";
          },
          toggleAlignDropdown() {
            this.showAlignDropdown = !this.showAlignDropdown;
          },
          handleClickOutside(event) {
            const isTextarea = event.target.tagName === "TEXTAREA";
            const isOutside = !this.$el.contains(event.target);
            const isIcon = event.target.closest(".k-input-icon");
            if (isOutside || isTextarea && !isIcon) {
              this.showAlignDropdown = false;
            }
          },
          handleEscape(event) {
            if (event.key === "Escape") {
              if (this.showAlignDropdown) {
                event.stopPropagation();
                event.preventDefault();
                this.showAlignDropdown = false;
              }
            }
          }
        },
        mounted() {
          this.$nextTick(() => {
            document.addEventListener("click", this.handleClickOutside, true);
            document.addEventListener("keydown", this.handleEscape);
            const textarea = this.$el.querySelector("textarea");
            if (textarea) {
              this.autoResize(textarea);
            }
          });
        },
        beforeDestroy() {
          document.removeEventListener("click", this.handleClickOutside, true);
          document.removeEventListener("keydown", this.handleEscape);
        },
        template: `
        <div class="k-field k-textarea-field pw-textarea-field" :data-align="currentAlign">
					<header v-if="label" class="k-field-header">
						<label class="k-label k-field-label">
							<span class="k-label-text">{{ label }}</span>
						</label>
					</header>
					<div class="k-input" data-type="textarea">
						<span class="k-input-element">
							<textarea
								:value="parseValue().text || ''"
								@input="handleInput"
								:placeholder="placeholder"
								class="k-string-input k-textarea-input pw-textarea"
							></textarea>
						</span>
					</div>
					<span class="k-input-icon pw-textarea-icon" @click.stop="toggleAlignDropdown">
						<svg aria-hidden="true" :data-type="'text-' + currentAlign" class="k-icon">
							<use :xlink:href="'#icon-text-' + currentAlign"></use>
						</svg>
						<dialog v-if="showAlignDropdown" class="k-dropdown-content pw-dropdown" data-theme="dark" open>
							<div class="k-navigate">
								<button
									v-for="option in alignOptions"
									:key="option"
									@click.stop="updateAlign(option)"
									type="button"
									class="k-button k-dropdown-item"
									data-has-icon="true"
								>
									<span class="k-button-icon">
										<svg class="k-icon"><use :xlink:href="'#icon-text-' + option"></use></svg>
									</span>
								</button>
							</div>
						</dialog>
					</span>
					<footer v-if="help" class="k-field-footer">
						<div class="k-help k-field-help k-text" v-html="help"></div>
					</footer>
				</div>
      `
      }
    }
  });
})();
