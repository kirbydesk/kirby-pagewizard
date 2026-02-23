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
      value: String,
      align: {
        type: String,
        default: "left"
      }
    }
  };
  var _sfc_render = function render() {
    var _vm = this, _c = _vm._self._c;
    return _vm.value && _vm.value.length ? _c("div", { staticClass: "k-button-group", attrs: { "data-align": _vm.align } }, _vm._l(_vm.value, function(item) {
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
        this.$emit("input", JSON.stringify({ text, align, level }));
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
        if (event.key === "Escape" && (this.showAlignDropdown || this.showLevelDropdown)) {
          event.stopPropagation();
          event.preventDefault();
          this.closeDropdowns();
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
			<header class="k-field-header" style="display:flex;align-items:center;overflow:visible;">
				<label v-if="label" class="k-label k-field-label" style="flex:1;">
					<span class="k-label-text">{{ label }}</span>
				</label>
				<span v-else style="flex:1;"></span>
				<div v-if="align || level" class="k-button-group">
					<span v-if="align" style="position:relative;">
						<button
							data-has-icon="true"
							data-has-text="false"
							aria-label="Align"
							data-size="xs"
							data-variant="filled"
							type="button"
							class="input-focus k-button"
							@click.stop="toggleAlignDropdown"
						><span class="k-button-icon">
							<svg aria-hidden="true" class="k-icon">
								<use :xlink:href="'#icon-text-' + currentAlign"></use>
							</svg>
						</span></button>
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
					<span v-if="level" style="position:relative;">
						<button
							data-has-icon="true"
							data-has-text="false"
							aria-label="Level"
							data-size="xs"
							data-variant="filled"
							type="button"
							class="input-focus k-button"
							@click.stop="toggleLevelDropdown"
						><span class="k-button-icon">
							<svg aria-hidden="true" class="k-icon">
								<use :xlink:href="'#icon-' + currentLevel"></use>
							</svg>
						</span></button>
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
				</div>
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
			</div>
			<footer v-if="help" class="k-field-footer">
				<div class="k-help k-field-help k-text" v-html="help"></div>
			</footer>
		</div>
	`
  };
  const pwtextarea = {
    props: {
      value: String,
      label: String,
      help: String,
      placeholder: String,
      align: { type: String, default: "left" },
      alignOptions: {
        type: Array,
        default: () => ["left", "center", "right"]
      }
    },
    data() {
      return {
        current: this.parse(this.value),
        showAlignDropdown: false,
        _closeHandler: null
      };
    },
    watch: {
      value(v) {
        this.current = this.parse(v);
      }
    },
    methods: {
      parse(val) {
        if (!val) return { text: "", align: this.align };
        try {
          const d = JSON.parse(val);
          return { text: d.text || "", align: d.align || this.align };
        } catch (e) {
          return { text: val, align: "left" };
        }
      },
      emit() {
        this.$emit("input", JSON.stringify({ text: this.current.text, align: this.current.align }));
      },
      onInput(e) {
        this.current.text = e.target.value;
        this.autoResize(e.target);
        this.emit();
      },
      setAlign(align) {
        this.current.align = align;
        this.showAlignDropdown = false;
        this.emit();
      },
      toggleAlignDropdown() {
        this.showAlignDropdown = !this.showAlignDropdown;
      },
      autoResize(el) {
        el.style.height = "auto";
        el.style.height = el.scrollHeight + "px";
      },
      handleClose(e) {
        if (!this.$el.contains(e.target)) {
          this.showAlignDropdown = false;
        }
      }
    },
    mounted() {
      this._closeHandler = this.handleClose;
      document.addEventListener("click", this._closeHandler, true);
      this.$nextTick(() => {
        const ta = this.$el.querySelector("textarea");
        if (ta) this.autoResize(ta);
      });
    },
    beforeDestroy() {
      document.removeEventListener("click", this._closeHandler, true);
    },
    template: `
		<div class="k-field pw-textarea-field">
			<header class="k-field-header" style="display:flex;align-items:center;overflow:visible;">
				<label v-if="label" class="k-label k-field-label" style="flex:1;">
					<span class="k-label-text">{{ label }}</span>
				</label>
				<span v-else style="flex:1;"></span>
				<div class="k-button-group">
					<span style="position:relative;">
						<button
							data-has-icon="true"
							data-has-text="false"
							aria-label="Align"
							data-size="xs"
							data-variant="filled"
							type="button"
							class="input-focus k-button"
							@click.stop="toggleAlignDropdown"
						><span class="k-button-icon">
							<svg aria-hidden="true" class="k-icon">
								<use :xlink:href="'#icon-text-' + current.align"></use>
							</svg>
						</span></button>
						<dialog v-if="showAlignDropdown" class="k-dropdown-content pw-dropdown" data-theme="dark" open>
							<div class="k-navigate">
								<button
									v-for="opt in alignOptions"
									:key="opt"
									type="button"
									class="k-button k-dropdown-item"
									data-has-icon="true"
									@click.stop="setAlign(opt)"
								>
									<span class="k-button-icon">
										<svg class="k-icon"><use :xlink:href="'#icon-text-' + opt"></use></svg>
									</span>
								</button>
							</div>
						</dialog>
					</span>
				</div>
			</header>
			<div class="k-input pw-textarea-field" data-type="textarea">
				<span class="k-input-element">
					<textarea
						:value="current.text"
						:placeholder="placeholder"
						class="k-string-input k-textarea-input pw-textarea"
						@input="onInput"
					></textarea>
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
      align: { type: String, default: "left" },
      writerModes: { type: Array, default: () => ["textarea", "writer", "markdown"] },
      writerMarks: { type: Array, default: () => ["bold", "italic", "underline", "strike", "link"] },
      writerNodes: { type: Array, default: () => ["heading", "bulletList", "orderedList"] },
      writerHeadings: { type: Array, default: () => [2, 3, 4] },
      writerToolbar: { type: Object, default: () => ({ inline: false }) }
    },
    data() {
      return {
        current: this.parse(this.value),
        showModeDropdown: false,
        showAlignDropdown: false,
        _closeHandler: null,
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
        return this.$t("pw.field.text-" + this.current.mode, this.current.mode);
      },
      translatedHelp() {
        return this.$t("pw.field.text-" + this.current.mode + ".help", "");
      },
      translatedPlaceholder() {
        return this.$t("pw.field.text-" + this.current.mode + ".placeholder", "");
      }
    },
    methods: {
      parse(val) {
        const fallbackMode = this.writerModes[0] || "textarea";
        const base = { mode: fallbackMode, align: this.align, textarea: "", writer: "", markdown: "" };
        if (!val) return base;
        try {
          const d = JSON.parse(val);
          if (d && typeof d === "object" && d.mode) {
            const mode = this.writerModes.includes(d.mode) ? d.mode : fallbackMode;
            return {
              mode,
              align: d.align || this.align,
              textarea: d.textarea || "",
              writer: d.writer || "",
              markdown: d.markdown || ""
            };
          }
        } catch (e) {
        }
        const allowed = ["textarea", "writer", "markdown"];
        return { ...base, mode: allowed.includes(val) ? val : "textarea" };
      },
      emit() {
        this._updating = true;
        this.$emit("input", JSON.stringify(this.current));
        this.$nextTick(() => {
          this._updating = false;
        });
      },
      setMode(mode) {
        this.current = { ...this.current, mode };
        this.showModeDropdown = false;
        this.emit();
      },
      setAlign(align) {
        this.current = { ...this.current, align };
        this.showAlignDropdown = false;
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
        el.style.minHeight = el.scrollHeight + "px";
      },
      toggleModeDropdown() {
        this.showModeDropdown = !this.showModeDropdown;
        if (this.showModeDropdown) this.showAlignDropdown = false;
      },
      toggleAlignDropdown() {
        this.showAlignDropdown = !this.showAlignDropdown;
        if (this.showAlignDropdown) this.showModeDropdown = false;
      },
      handleClose(e) {
        if (!this.$el.contains(e.target)) {
          this.showModeDropdown = false;
          this.showAlignDropdown = false;
        }
      }
    },
    mounted() {
      this._closeHandler = this.handleClose;
      document.addEventListener("click", this._closeHandler, true);
      this.$nextTick(() => {
        const ta = this.$el.querySelector("textarea");
        if (ta) this.autoResize(ta);
      });
    },
    beforeDestroy() {
      document.removeEventListener("click", this._closeHandler, true);
    },
    template: `
		<div class="k-field pw-editor-field">
			<header class="k-field-header" style="display:flex;align-items:center;overflow:visible;">
				<label class="k-label k-field-label" style="flex:1;">
					<span class="k-label-text">{{ $t('pw.field.text') }}</span>
				</label>
				<div class="k-button-group">
					<span style="position:relative;">
						<button
							:data-has-icon="current.align ? 'true' : 'false'"
							:data-has-text="current.align ? 'false' : 'true'"
							aria-label="Align"
							data-size="xs"
							data-variant="filled"
							type="button"
							class="input-focus k-button"
							@click.stop="toggleAlignDropdown"
						><span v-if="current.align" class="k-button-icon">
							<svg aria-hidden="true" class="k-icon">
								<use :xlink:href="'#icon-text-' + current.align"></use>
							</svg>
						</span><span v-else class="k-button-text">···</span></button>
						<dialog v-if="showAlignDropdown" class="k-dropdown-content pw-dropdown" data-theme="dark" open>
							<div class="k-navigate">
								<button v-for="opt in ['left','center','right']" :key="opt" type="button" class="k-button k-dropdown-item" data-has-icon="true" @click.stop="setAlign(opt)">
									<span class="k-button-icon"><svg class="k-icon"><use :xlink:href="'#icon-text-' + opt"></use></svg></span>
								</button>
							</div>
						</dialog>
					</span>
					<span v-if="showModeSwitcher" style="position:relative;">
						<button
							data-has-icon="false"
							data-has-text="true"
							aria-label="Mode"
							data-size="xs"
							data-variant="filled"
							type="button"
							class="input-focus k-button"
							@click.stop="toggleModeDropdown"
						><span class="k-button-text"> {{ translatedLabel }} </span></button>
						<dialog v-if="showModeDropdown" class="k-dropdown-content pw-dropdown" data-theme="dark" open>
							<div class="k-navigate">
								<button v-for="m in writerModes" :key="m" type="button" class="k-button k-dropdown-item" data-has-text="true" data-has-icon="false" @click.stop="setMode(m)">
									<span class="k-button-text">{{ $t('pw.field.text-' + m) }}</span>
								</button>
							</div>
						</dialog>
					</span>
				</div>
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
			<div v-show="current.mode === 'markdown'" class="k-input pw-editor-textarea" data-type="textarea">
				<span class="k-input-element">
					<textarea
						:value="current.markdown"
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
      alwaysVisible: { type: Boolean, default: false }
    },
    data() {
      return {
        current: this.value || this.align,
        show: false,
        btnEl: null,
        dropdownEl: null,
        container: null,
        _closeHandler: null,
        _observer: null,
        _nextColumn: null
      };
    },
    watch: {
      value(v) {
        this.current = v || this.align;
        this.updateIcon();
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
        this.btnEl = document.createElement("button");
        this.btnEl.type = "button";
        this.btnEl.className = "input-focus k-button";
        this.btnEl.setAttribute("data-has-icon", "true");
        this.btnEl.setAttribute("data-has-text", "false");
        this.btnEl.setAttribute("data-size", "xs");
        this.btnEl.setAttribute("data-variant", "filled");
        this.btnEl.setAttribute("aria-label", "Align");
        this.updateIcon();
        this.container.appendChild(this.btnEl);
        this.btnEl.addEventListener("click", (e) => {
          e.stopPropagation();
          this.toggleDropdown();
        });
        this._closeHandler = (e) => {
          if (!this.container.contains(e.target)) {
            this.closeDropdown();
          }
        };
        document.addEventListener("click", this._closeHandler);
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
      updateIcon() {
        if (!this.btnEl) return;
        const icon = this.current || "left";
        this.btnEl.innerHTML = '<span class="k-button-icon"><svg class="k-icon"><use xlink:href="#icon-text-' + icon + '"></use></svg></span>';
      },
      toggleDropdown() {
        if (this.show) {
          this.closeDropdown();
        } else {
          this.showDropdown();
        }
      },
      showDropdown() {
        if (this.dropdownEl) this.dropdownEl.remove();
        this.dropdownEl = document.createElement("dialog");
        this.dropdownEl.className = "k-dropdown-content pw-dropdown";
        this.dropdownEl.setAttribute("data-theme", "dark");
        this.dropdownEl.setAttribute("open", "");
        const navEl = document.createElement("div");
        navEl.className = "k-navigate";
        ["left", "center", "right"].forEach((opt) => {
          const btn = document.createElement("button");
          btn.type = "button";
          btn.className = "k-button k-dropdown-item";
          btn.setAttribute("data-has-icon", "true");
          btn.innerHTML = '<span class="k-button-icon"><svg class="k-icon"><use xlink:href="#icon-text-' + opt + '"></use></svg></span>';
          btn.addEventListener("click", (e) => {
            e.stopPropagation();
            this.select(opt);
          });
          navEl.appendChild(btn);
        });
        this.dropdownEl.appendChild(navEl);
        this.container.appendChild(this.dropdownEl);
        this.show = true;
      },
      closeDropdown() {
        if (this.dropdownEl) {
          this.dropdownEl.remove();
          this.dropdownEl = null;
        }
        this.show = false;
      },
      select(opt) {
        this.current = opt;
        this.updateIcon();
        this.closeDropdown();
        this.$emit("input", opt);
      }
    },
    beforeDestroy() {
      if (this._observer) this._observer.disconnect();
      if (this.container) this.container.remove();
      if (this._closeHandler) document.removeEventListener("click", this._closeHandler);
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
        icons: []
      };
    },
    watch: {
      value(v) {
        this.current = v || "";
      }
    },
    async created() {
      try {
        const res = await this.$api.get("pagewizard/icons");
        this.icons = Array.isArray(res) ? res : [];
      } catch (e) {
        this.icons = [];
      }
    },
    methods: {
      select(id) {
        if (this.disabled) return;
        this.current = id;
        this.$emit("input", id);
      }
    },
    template: `
		<k-field v-bind="$props" class="pw-icon-field">
			<div class="pw-icon-grid">
				<button
					type="button"
					class="pw-icon-btn pw-icon-none"
					:class="{ 'is-active': !current }"
					:disabled="disabled"
					title="None"
					@click="select('')"
				>–</button>
				<button
					v-for="icon in icons"
					:key="icon.id"
					type="button"
					class="pw-icon-btn"
					:class="{ 'is-active': current === icon.id }"
					:disabled="disabled"
					:title="icon.label"
					@click="select(icon.id)"
				><span v-html="icon.svg"></span></button>
			</div>
		</k-field>
	`
  };
  panel.plugin("kirbydesk/kirby-pagewizard", {
    blocks: {
      pwButton,
      pwButtons,
      pwFooter,
      pwFooterItem
    },
    fields: {
      htmlheadline,
      pwtext,
      pwtextarea,
      pweditor,
      pwalign,
      pwicon
    },
    icons: {
      "expand-left": '<path d="M10.071 4.92896L11.4852 6.34317L6.82834 11L16.0002 11.0002L16.0002 13.0002L6.82839 13L11.4852 17.6569L10.071 19.0711L2.99994 12L10.071 4.92896ZM18.0001 19V4.99997H20.0001V19H18.0001Z"/>',
      "expand-right": '<path d="M17.1717 11L12.5148 6.34317L13.929 4.92896L21.0001 12L13.929 19.0711L12.5148 17.6569L17.1716 13L7.9998 13.0002L7.99978 11.0002L17.1717 11ZM3.99985 19L3.99985 4.99997H5.99985V19H3.99985Z"/>',
      "expand-left-right": '<path d="M7.44975 7.05029L2.5 12L7.44727 16.9473L8.86148 15.5331L6.32843 13H17.6708L15.1358 15.535L16.55 16.9493L21.5 11.9996L16.5503 7.0498L15.136 8.46402L17.6721 11H6.32843L8.86396 8.46451L7.44975 7.05029Z"/>',
      "expand-width": '<path d="M2 6L2 18H4L4 6H2ZM9.44975 7.05025L4.5 12L9.44727 16.9473L9.44826 13H14.5501L14.55 16.9492L19.5 11.9995L14.5503 7.04976L14.5502 11H9.44876L9.44975 7.05025ZM20 6H22V18H20V6Z"/>',
      "editor-mode": '<path d="M16.7574 2.99678L14.7574 4.99678H5V18.9968H19V9.23943L21 7.23943V19.9968C21 20.5491 20.5523 20.9968 20 20.9968H4C3.44772 20.9968 3 20.5491 3 19.9968V3.99678C3 3.4445 3.44772 2.99678 4 2.99678H16.7574ZM20.4853 2.09729L21.8995 3.5115L12.7071 12.7039L11.2954 12.7064L11.2929 11.2897L20.4853 2.09729Z"/>',
      "legal": '<path d="M12.9985 2L12.9979 3.278L17.9985 4.94591L21.631 3.73509L22.2634 5.63246L19.2319 6.643L22.3272 15.1549C21.2353 16.2921 19.6996 17 17.9985 17C16.2975 17 14.7618 16.2921 13.6699 15.1549L16.7639 6.643L12.9979 5.387V19H16.9985V21H6.99854V19H10.9979V5.387L7.23192 6.643L10.3272 15.1549C9.23528 16.2921 7.69957 17 5.99854 17C4.2975 17 2.76179 16.2921 1.66992 15.1549L4.76392 6.643L1.73363 5.63246L2.36608 3.73509L5.99854 4.94591L10.9979 3.278L10.9985 2H12.9985ZM17.9985 9.10267L16.04 14.4892C16.628 14.8201 17.2979 15 17.9985 15C18.6992 15 19.3691 14.8201 19.957 14.4892L17.9985 9.10267ZM5.99854 9.10267L4.04004 14.4892C4.62795 14.8201 5.29792 15 5.99854 15C6.69916 15 7.36912 14.8201 7.95703 14.4892L5.99854 9.10267Z"/>',
      "featurelist": '<path d="M13 4H21V6H13V4ZM13 11H21V13H13V11ZM13 18H21V20H13V18ZM6.5 19C5.39543 19 4.5 18.1046 4.5 17C4.5 15.8954 5.39543 15 6.5 15C7.60457 15 8.5 15.8954 8.5 17C8.5 18.1046 7.60457 19 6.5 19ZM6.5 21C8.70914 21 10.5 19.2091 10.5 17C10.5 14.7909 8.70914 13 6.5 13C4.29086 13 2.5 14.7909 2.5 17C2.5 19.2091 4.29086 21 6.5 21ZM5 6V9H8V6H5ZM3 4H10V11H3V4Z"/>',
      "cardlets": '<path d="M3 4C3 3.44772 3.44772 3 4 3H10C10.5523 3 11 3.44772 11 4V10C11 10.5523 10.5523 11 10 11H4C3.44772 11 3 10.5523 3 10V4ZM3 14C3 13.4477 3.44772 13 4 13H10C10.5523 13 11 13.4477 11 14V20C11 20.5523 10.5523 21 10 21H4C3.44772 21 3 20.5523 3 20V14ZM13 4C13 3.44772 13.4477 3 14 3H20C20.5523 3 21 3.44772 21 4V10C21 10.5523 20.5523 11 20 11H14C13.4477 11 13 10.5523 13 10V4ZM13 14C13 13.4477 13.4477 13 14 13H20C20.5523 13 21 13.4477 21 14V20C21 20.5523 20.5523 21 20 21H14C13.4477 21 13 20.5523 13 20V14ZM15 5V9H19V5H15ZM15 15V19H19V15H15ZM5 5V9H9V5H5ZM5 15V19H9V15H5Z"/>',
      "faq": '<path d="M5.45455 15L1 18.5V3C1 2.44772 1.44772 2 2 2H17C17.5523 2 18 2.44772 18 3V15H5.45455ZM4.76282 13H16V4H3V14.3851L4.76282 13ZM8 17H18.2372L20 18.3851V8H21C21.5523 8 22 8.44772 22 9V22.5L17.5455 19H9C8.44772 19 8 18.5523 8 18V17Z"/>',
      "definitionlist": '<path d="M8 4H21V6H8V4ZM3 3.5H6V6.5H3V3.5ZM3 10.5H6V13.5H3V10.5ZM3 17.5H6V20.5H3V17.5ZM8 11H21V13H8V11ZM8 18H21V20H8V18Z"/>',
      "item": '<path d="M4 3H20C20.5523 3 21 3.44772 21 4V20C21 20.5523 20.5523 21 20 21H4C3.44772 21 3 20.5523 3 20V4C3 3.44772 3.44772 3 4 3ZM5 5V19H19V5H5ZM11.0026 16L6.75999 11.7574L8.17421 10.3431L11.0026 13.1716L16.6595 7.51472L18.0737 8.92893L11.0026 16Z"/>'
    }
  });
})();
