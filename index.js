(function(){"use strict";function o(e,t,s,i,n,r,c,d){var a=typeof e=="function"?e.options:e;return t&&(a.render=t,a.staticRenderFns=s,a._compiled=!0),r&&(a._scopeId="data-v-"+r),{exports:e,options:a}}const f={};var w=function(){var t=this,s=t._self._c;return s("div",{staticClass:"pwPreview",on:{dblclick:t.open}},[t.content.name?s("div",{staticClass:"heading"},[t._v(" "+t._s(t.content.name)+" ")]):s("div",{staticClass:"heading placeholder"},[t._v(" "+t._s(t.$t("pw.footer.name"))+" ... ")]),t._l(t.content.blocks,function(i){return s("div",{key:i.id,staticClass:"items"},[s("div",{staticClass:"linktext",class:{placeholder:!i.content.linktext}},[s("span",[t._v(t._s(i.content.linktext||t.$t("pw.field.link-text.placeholder")))]),i.content.linktarget?s("span",{staticClass:"k-icon"},[s("k-icon",{attrs:{type:"open"}})],1):t._e()])])})],2)},v=[],g=o(f,w,v,!1,null,"c4342998");const k=g.exports,b={};var m=function(){var t=this,s=t._self._c;return s("div",{staticClass:"pwPreview",on:{dblclick:t.open}},[t.content.linktext?s("div",{staticClass:"linktext"},[s("span",[t._v(t._s(t.content.linktext))]),t.content.linktarget?s("span",{staticClass:"k-icon"},[s("k-icon",{attrs:{type:"open"}})],1):t._e()]):s("div",{staticClass:"placeholder"},[t._v(" "+t._s(t.$t("pw.field.link-text.placeholder"))+" ")])])},_=[],L=o(b,m,_,!1,null,"4929f93f");const x=L.exports,y={props:{value:String,icon:String,layout:String}};var H=function(){var t=this,s=t._self._c;return s("div",{staticClass:"blockinfo"},[s("div",[s("svg",{staticClass:"k-icon",attrs:{"aria-hidden":"true"}},[s("use",{attrs:{"xlink:href":"#icon-"+t.icon}})]),t._v(" "+t._s(t.value)+" "),t.layout?s("span",[t._v("("+t._s(t.layout)+")")]):t._e()])])},V=[],C=o(y,H,V,!1,null,"a7ff9748");const z={components:{pwBlockinfo:C.exports},data(){return{sharedItems:[]}},computed:{label(){if(!this.content.sharedid)return"— No shared block selected —";const e=this.sharedItems.find(t=>t.value===this.content.sharedid);return e?e.label+(e.type?" ("+e.type+")":""):this.content.sharedid}},async created(){try{const e=await this.$api.get("pagewizard/shared");this.sharedItems=Array.isArray(e)?e:[]}catch{this.sharedItems=[]}}};var S=function(){var t=this,s=t._self._c;return s("div",{staticClass:"pwPreview",attrs:{"data-kirbyblock":"shared"},on:{dblclick:t.open}},[s("pwBlockinfo",{attrs:{value:t.label,icon:"share"}})],1)},M=[],D=o(z,S,M,!1,null,null);const $=D.exports,A={props:{content:{type:Object,default:()=>({})},alignDefault:{type:String,default:"left"}},computed:{align(){return this.content.buttonalignment||this.alignDefault}}};var Z=function(){var i;var t=this,s=t._self._c;return s("div",{staticClass:"pwButton",attrs:{"data-align":t.align}},[s("button",{staticClass:"k-button",attrs:{"data-has-text":"true","data-responsive":"true","data-size":"sm","data-variant":"filled",type:"button"}},[(i=t.content.linktext)!=null&&i.length?s("span",{staticClass:"k-button-text",domProps:{innerHTML:t._s(t.content.linktext)}}):s("span",{staticClass:"k-button-text placeholder"},[t._v(" "+t._s(t.$t("pw.field.link-text.placeholder"))+" ")])])])},E=[],O=o(A,Z,E,!1,null,"2ddb2c16");const I=O.exports,T={props:{value:String,align:{type:String,default:"left"}}};var N=function(){var t=this,s=t._self._c;return t.value&&t.value.length?s("div",{staticClass:"k-button-group",attrs:{"data-align":t.align}},t._l(t.value,function(i){return s("div",{key:i.id,class:{ishidden:i.isHidden}},[s("button",{staticClass:"k-button",attrs:{type:"button","data-has-text":"true","data-responsive":"true","data-size":"md","data-variant":"filled"}},[i.content.linktext.length?s("span",{staticClass:"k-button-text"},[t._v(" "+t._s(i.content.linktext)+" ")]):s("span",{staticClass:"k-button-text placeholder"},[t._v(" "+t._s(t.$t("pw.field.link-text.placeholder"))+" ")])])])}),0):t._e()},F=[],B=o(T,N,F,!1,null,"a023afc4");const P=B.exports,R={props:{label:String,help:String},computed:{translatedLabel(){return this.$t(this.label,this.label)},dataTheme(){return this.$attrs["data-theme"]||null}},template:`
		<header class="k-headline-field" :data-theme="dataTheme">
			<h2 class="k-headline" v-html="translatedLabel"></h2>
			<footer v-if="help" class="k-field-footer">
				<div class="k-help k-field-help k-text" v-html="help"></div>
			</footer>
		</header>
	`},q={extends:"k-text-field",props:{label:String,help:String,placeholder:String,value:String,align:String,level:String,size:String,alignOptions:{default:null},levelOptions:{default:null},sizeOptions:{type:Array,default:null}},data(){return{currentAlign:this.parseValue().align||this.align||"left",currentLevel:this.parseValue().level||this.level||"h2",currentSize:this.parseValue().size||this.size||"2xl",showAlignDropdown:!1,showLevelDropdown:!1,showSizeDropdown:!1}},watch:{value(e){const t=this.parseValue();t.align&&(this.currentAlign=t.align),t.level&&(this.currentLevel=t.level),t.size&&(this.currentSize=t.size)}},methods:{parseValue(){if(!this.value)return{};try{return typeof this.value=="string"?JSON.parse(this.value):this.value}catch{return{text:this.value}}},emitValue(e,t,s,i){this.$emit("input",JSON.stringify({text:e,align:t,level:s,size:i}))},updateAlign(e){this.currentAlign=e,this.showAlignDropdown=!1;const t=this.parseValue();this.emitValue(t.text||"",e,t.level||this.currentLevel,t.size||this.currentSize)},updateLevel(e){this.currentLevel=e,this.showLevelDropdown=!1;const t=this.parseValue();this.emitValue(t.text||"",t.align||this.currentAlign,e,t.size||this.currentSize)},updateSize(e){this.currentSize=e,this.showSizeDropdown=!1;const t=this.parseValue();this.emitValue(t.text||"",t.align||this.currentAlign,t.level||this.currentLevel,e)},handleInput(e){this.emitValue(e.target.value,this.currentAlign,this.currentLevel,this.currentSize)},closeDropdowns(){this.showAlignDropdown=!1,this.showLevelDropdown=!1,this.showSizeDropdown=!1},toggleLevelDropdown(){this.showAlignDropdown=!1,this.showSizeDropdown=!1,this.showLevelDropdown=!this.showLevelDropdown},toggleAlignDropdown(){this.showLevelDropdown=!1,this.showSizeDropdown=!1,this.showAlignDropdown=!this.showAlignDropdown},toggleSizeDropdown(){this.showAlignDropdown=!1,this.showLevelDropdown=!1,this.showSizeDropdown=!this.showSizeDropdown},handleClickOutside(e){this.$el.contains(e.target)||this.closeDropdowns()},handleEscape(e){e.key==="Escape"&&(this.showAlignDropdown||this.showLevelDropdown||this.showSizeDropdown)&&(e.stopPropagation(),e.preventDefault(),this.closeDropdowns())},sizeLabel(e){return this.$t("pw.option."+e,e)}},mounted(){this.$nextTick(()=>{document.addEventListener("click",this.handleClickOutside,!0),document.addEventListener("keydown",this.handleEscape)})},beforeDestroy(){document.removeEventListener("click",this.handleClickOutside,!0),document.removeEventListener("keydown",this.handleEscape)},template:`
		<div class="k-field k-text-field" :data-align="currentAlign" :data-level="currentLevel" :data-size="currentSize">
			<header class="k-field-header" style="display:flex;align-items:center;overflow:visible;">
				<label v-if="label" class="k-label k-field-label" style="flex:1;">
					<span class="k-label-text">{{ label }}</span>
				</label>
				<span v-else style="flex:1;"></span>
				<div v-if="(align && alignOptions) || (level && levelOptions) || (size && sizeOptions)" class="k-button-group">
					<span v-if="align && alignOptions" style="position:relative;">
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
					<span v-if="size && sizeOptions" style="position:relative;">
						<button
							data-has-icon="false"
							data-has-text="true"
							aria-label="Size"
							data-size="xs"
							data-variant="filled"
							type="button"
							class="input-focus k-button"
							@click.stop="toggleSizeDropdown"
						><span class="k-button-text pw-size-label">{{ sizeLabel(currentSize) }}</span></button>
						<dialog v-if="showSizeDropdown" class="k-dropdown-content pw-dropdown" data-theme="dark" open>
							<div class="k-navigate">
								<button
									v-for="option in sizeOptions"
									:key="option"
									@click.stop="updateSize(option)"
									type="button"
									class="k-button k-dropdown-item"
									data-has-text="true"
									data-has-icon="false"
								>
									<span class="k-button-text pw-size-label">{{ sizeLabel(option) }}</span>
								</button>
							</div>
						</dialog>
					</span>
					<span v-if="level && levelOptions" style="position:relative;">
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
	`},j={props:{value:String,label:String,placeholder:String,fieldHelp:String,align:{type:String,default:"left"},alignOptions:{type:Array,default:()=>["left","center","right"]},size:{type:String,default:null},sizeOptions:{type:Array,default:null},defaultMode:{type:String,default:null},writerModes:{type:Array,default:()=>["textarea","writer","markdown"]},writerMarks:{type:Array,default:()=>["bold","italic","underline","strike","link"]},writerNodes:{type:Array,default:()=>["heading","bulletList","orderedList"]},writerHeadings:{type:Array,default:()=>[2,3,4]},writerToolbar:{type:Object,default:()=>({inline:!1})}},data(){return{current:this.parse(this.value),showModeDropdown:!1,showAlignDropdown:!1,showSizeDropdown:!1,_closeHandler:null,_updating:!1}},watch:{value(e){this._updating||(this.current=this.parse(e))}},computed:{showModeSwitcher(){return this.writerModes.length>=2},translatedLabel(){return this.label||this.$t("pw.field.text")},modeLabel(){return this.$t("pw.field.text-"+this.current.mode,this.current.mode)},translatedHelp(){return this.fieldHelp||this.$t("pw.field.text-"+this.current.mode+".help","")},translatedPlaceholder(){return this.placeholder||this.$t("pw.field.text-"+this.current.mode+".placeholder","")}},methods:{parse(e){const t=this.defaultMode&&this.writerModes.includes(this.defaultMode)?this.defaultMode:this.writerModes[0]||"textarea",s={mode:t,align:this.align,size:this.size,textarea:"",writer:"",markdown:""};if(!e)return s;try{const n=JSON.parse(e);if(n&&typeof n=="object"&&n.mode)return{mode:this.writerModes.includes(n.mode)?n.mode:t,align:n.align||this.align,size:n.size||this.size,textarea:n.textarea||"",writer:n.writer||"",markdown:n.markdown||""}}catch{}return{...s,mode:["textarea","writer","markdown"].includes(e)?e:"textarea"}},emit(){this._updating=!0,this.$emit("input",JSON.stringify(this.current)),this.$nextTick(()=>{this._updating=!1})},setMode(e){this.current={...this.current,mode:e},this.showModeDropdown=!1,this.emit()},setAlign(e){this.current={...this.current,align:e},this.showAlignDropdown=!1,this.emit()},setSize(e){this.current={...this.current,size:e},this.showSizeDropdown=!1,this.emit()},sizeLabel(e){return this.$t("pw.option."+e,e)},onTextInput(e){this.current={...this.current,[this.current.mode]:e.target.value},this.autoResize(e.target),this.emit()},onWriterInput(e){this.current={...this.current,writer:e},this.emit()},autoResize(e){e.style.height="auto",e.style.height=e.scrollHeight+"px"},toggleModeDropdown(){this.showModeDropdown=!this.showModeDropdown,this.showModeDropdown&&(this.showAlignDropdown=!1,this.showSizeDropdown=!1)},toggleAlignDropdown(){this.showAlignDropdown=!this.showAlignDropdown,this.showAlignDropdown&&(this.showModeDropdown=!1,this.showSizeDropdown=!1)},toggleSizeDropdown(){this.showSizeDropdown=!this.showSizeDropdown,this.showSizeDropdown&&(this.showAlignDropdown=!1,this.showModeDropdown=!1)},handleClose(e){this.$el.contains(e.target)||(this.showModeDropdown=!1,this.showAlignDropdown=!1,this.showSizeDropdown=!1)}},mounted(){this._closeHandler=this.handleClose,document.addEventListener("click",this._closeHandler,!0),this.$nextTick(()=>{const e=this.$el.querySelector("textarea");e&&this.autoResize(e)})},beforeDestroy(){document.removeEventListener("click",this._closeHandler,!0)},template:`
		<div class="k-field pw-editor-field">
			<header class="k-field-header" style="display:flex;align-items:center;overflow:visible;">
				<label class="k-label k-field-label" style="flex:1;">
					<span class="k-label-text">{{ translatedLabel }}</span>
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
								<button v-for="opt in alignOptions" :key="opt" type="button" class="k-button k-dropdown-item" data-has-icon="true" @click.stop="setAlign(opt)">
									<span class="k-button-icon"><svg class="k-icon"><use :xlink:href="'#icon-text-' + opt"></use></svg></span>
								</button>
							</div>
						</dialog>
					</span>
					<span v-if="size && sizeOptions" style="position:relative;">
						<button
							data-has-icon="false"
							data-has-text="true"
							aria-label="Size"
							data-size="xs"
							data-variant="filled"
							type="button"
							class="input-focus k-button"
							@click.stop="toggleSizeDropdown"
						><span class="k-button-text pw-size-label">{{ sizeLabel(current.size) }}</span></button>
						<dialog v-if="showSizeDropdown" class="k-dropdown-content pw-dropdown" data-theme="dark" open>
							<div class="k-navigate">
								<button v-for="opt in sizeOptions" :key="opt" type="button" class="k-button k-dropdown-item" data-has-text="true" data-has-icon="false" @click.stop="setSize(opt)">
									<span class="k-button-text pw-size-label">{{ sizeLabel(opt) }}</span>
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
						><span class="k-button-text"> {{ modeLabel }} </span></button>
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
	`},J={props:{value:String,align:{type:String,default:"left"},alignOptions:{type:Array,default:()=>["left","center","right"]},alwaysVisible:{type:Boolean,default:!1}},data(){return{current:this.value||this.align,show:!1,btnEl:null,dropdownEl:null,container:null,_closeHandler:null,_observer:null,_nextColumn:null}},watch:{value(e){this.current=e||this.align,this.updateIcon()}},mounted(){!this.value&&this.current&&this.$emit("input",this.current),this.$nextTick(()=>{const e=this.$el.closest(".k-column");e&&(e.style.display="none");const t=e==null?void 0:e.nextElementSibling,s=t==null?void 0:t.querySelector(".k-field-header");if(!s)return;this.container=document.createElement("span"),this.container.className="pw-align-btn",this.container.style.cssText="position:relative;display:flex;align-items:center;",this.btnEl=document.createElement("button"),this.btnEl.type="button",this.btnEl.className="input-focus k-button",this.btnEl.setAttribute("data-has-icon","true"),this.btnEl.setAttribute("data-has-text","false"),this.btnEl.setAttribute("data-size","xs"),this.btnEl.setAttribute("data-variant","filled"),this.btnEl.setAttribute("aria-label","Align"),this.updateIcon(),this.container.appendChild(this.btnEl),this.btnEl.addEventListener("click",n=>{n.stopPropagation(),this.toggleDropdown()}),this._closeHandler=n=>{this.container.contains(n.target)||this.closeDropdown()},document.addEventListener("click",this._closeHandler);const i=s.querySelector(".k-button");i&&i.parentElement!==s?i.parentElement.prepend(this.container):i?s.insertBefore(this.container,i):s.appendChild(this.container),this._nextColumn=t,this.updateVisibility(),this._observer=new MutationObserver(()=>this.updateVisibility()),this._observer.observe(t,{childList:!0,subtree:!0})})},methods:{updateVisibility(){if(!this.container||!this._nextColumn)return;if(this.alwaysVisible){this.container.style.display="flex";return}const e=this._nextColumn.querySelector(".k-item, .k-block, .k-structure-item")!==null;this.container.style.display=e?"flex":"none"},updateIcon(){if(!this.btnEl)return;const e=this.current||"left";this.btnEl.innerHTML='<span class="k-button-icon"><svg class="k-icon"><use xlink:href="#icon-text-'+e+'"></use></svg></span>'},toggleDropdown(){this.show?this.closeDropdown():this.showDropdown()},showDropdown(){this.dropdownEl&&this.dropdownEl.remove(),this.dropdownEl=document.createElement("dialog"),this.dropdownEl.className="k-dropdown-content pw-dropdown",this.dropdownEl.setAttribute("data-theme","dark"),this.dropdownEl.setAttribute("open","");const e=document.createElement("div");e.className="k-navigate",this.alignOptions.forEach(t=>{const s=document.createElement("button");s.type="button",s.className="k-button k-dropdown-item",s.setAttribute("data-has-icon","true"),s.innerHTML='<span class="k-button-icon"><svg class="k-icon"><use xlink:href="#icon-text-'+t+'"></use></svg></span>',s.addEventListener("click",i=>{i.stopPropagation(),this.select(t)}),e.appendChild(s)}),this.dropdownEl.appendChild(e),this.container.appendChild(this.dropdownEl),this.show=!0},closeDropdown(){this.dropdownEl&&(this.dropdownEl.remove(),this.dropdownEl=null),this.show=!1},select(e){this.current=e,this.updateIcon(),this.closeDropdown(),this.$emit("input",e)}},beforeDestroy(){this._observer&&this._observer.disconnect(),this.container&&this.container.remove(),this._closeHandler&&document.removeEventListener("click",this._closeHandler)},template:'<div style="display:none"></div>'},W={props:{value:String,label:String,help:String,disabled:Boolean},data(){return{current:this.value||"",icons:[],search:"",setName:""}},watch:{value(e){this.current=e||""}},computed:{filtered(){const e=this.search.trim().toLowerCase();return e?this.icons.filter(t=>t.id.toLowerCase().includes(e)):[]},selectedIcon(){return this.current&&this.icons.find(e=>e.svg===this.current)||null},showCount(){return this.search.trim()?this.filtered.length:this.icons.length}},async created(){try{const e=await this.$api.get("pagewizard/config"),t=e["icon-set"];this.setName=e["icon-set-name"]||t;const s=await this.$api.get("pagewizard/icons/"+t);this.icons=Array.isArray(s)?s:[]}catch{this.icons=[]}},methods:{select(e){this.disabled||(this.current=e?e.svg:"",this.$emit("input",this.current))},clear(){this.disabled||(this.current="",this.$emit("input",""))},isActive(e){return this.current===e.svg}},template:`
		<k-field v-bind="$props" class="pw-icon-field">
			<div class="pw-icon-search">
				<div class="pw-icon-input-wrap">
					<k-input
						type="text"
						:placeholder="$t('pw.field.icon.placeholder')"
						:value="search"
						@input="search = $event"
					/>
					<span class="pw-icon-count">{{ showCount }}</span>
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
	`},Y={extends:"k-text-field",mounted(){this.$nextTick(()=>{var d,a,p,h;if(!(((d=this.endpoints)==null?void 0:d.field)||"").includes("/sharedblocks/")){this.$el&&(this.$el.style.display="none");return}const s=new Date,i=l=>String(l).padStart(2,"0"),n=((h=(p=(a=this.$panel)==null?void 0:a.drawer)==null?void 0:p.props)==null?void 0:h.title)||"",c=`${n?n+" ":""}${s.getFullYear()}-${i(s.getMonth()+1)}-${i(s.getDate())} ${i(s.getHours())}:${i(s.getMinutes())}`;this.value||(this.$emit("input",c),setTimeout(()=>{var u;const l=(u=this.$el)==null?void 0:u.querySelector("input");l&&(l.style.color="var(--color-gray-500, #999)",l.addEventListener("input",()=>{l.style.color=""},{once:!0}))},0))})}},G={data(){return{sets:[],activeSet:null,icons:[],search:"",copied:null}},computed:{filtered(){const e=this.search.trim().toLowerCase();return e?this.icons.filter(t=>t.id.toLowerCase().includes(e)):this.icons}},async created(){try{if(this.sets=await this.$api.get("pagewizard/icons/sets"),this.sets.length){const e=this.sets.find(t=>t!=="custom")||this.sets[0];await this.loadSet(e)}}catch{}},methods:{async loadSet(e){this.activeSet=e,this.search="";try{const t=await this.$api.get("pagewizard/icons/"+e);this.icons=Array.isArray(t)?t:[]}catch{this.icons=[]}},async copy(e){try{await navigator.clipboard.writeText(e),this.copied=e,setTimeout(()=>{this.copied=null},2e3)}catch{}}}};var K=function(){var t=this,s=t._self._c;return s("k-panel-inside",{staticClass:"pw-icons-view"},[s("k-header",{scopedSlots:t._u([{key:"right",fn:function(){return[s("k-button-group",t._l(t.sets,function(i){return s("k-button",{key:i,attrs:{text:i,theme:t.activeSet===i?"positive":null,variant:"filled",size:"sm"},on:{click:function(n){return t.loadSet(i)}}})}),1)]},proxy:!0}])},[t._v(" "+t._s(t.$t("pw.icon.reference"))+" ")]),s("div",{staticClass:"pw-icons-search"},[s("k-input",{attrs:{type:"text",placeholder:t.$t("pw.icon.search"),value:t.search},on:{input:function(i){t.search=i}}}),s("span",{staticClass:"pw-icons-count"},[t._v(t._s(t.filtered.length)+" / "+t._s(t.icons.length))])],1),s("div",{staticClass:"pw-icons-grid"},t._l(t.filtered,function(i){return s("button",{key:i.id,staticClass:"pw-icons-item",class:{"is-custom":i.custom},attrs:{title:i.id},on:{click:function(n){return t.copy(i.id)}}},[s("span",{staticClass:"pw-icons-svg",domProps:{innerHTML:t._s(i.svg)}}),s("span",{staticClass:"pw-icons-label"},[t._v(t._s(i.id))])])}),0),t.copied?s("k-notification",{attrs:{theme:"positive",type:"alert"}},[t._v(' "'+t._s(t.copied)+'" '+t._s(t.$t("pw.icon.copied"))+" ")]):t._e()],1)},Q=[],U=o(G,K,Q,!1,null,null);const X=U.exports;panel.plugin("kirbydesk/kirby-pagewizard",{blocks:{pwButton:I,pwButtons:P,pwFooter:k,pwFooterItem:x,pwShared:$},fields:{htmlheadline:R,pwtext:q,pweditor:j,pwalign:J,pwicon:W,pwsharedname:Y},components:{"pw-icons-view":X},icons:{"expand-left":'<path d="M10.071 4.92896L11.4852 6.34317L6.82834 11L16.0002 11.0002L16.0002 13.0002L6.82839 13L11.4852 17.6569L10.071 19.0711L2.99994 12L10.071 4.92896ZM18.0001 19V4.99997H20.0001V19H18.0001Z"/>',"expand-right":'<path d="M17.1717 11L12.5148 6.34317L13.929 4.92896L21.0001 12L13.929 19.0711L12.5148 17.6569L17.1716 13L7.9998 13.0002L7.99978 11.0002L17.1717 11ZM3.99985 19L3.99985 4.99997H5.99985V19H3.99985Z"/>',"expand-left-right":'<path d="M7.44975 7.05029L2.5 12L7.44727 16.9473L8.86148 15.5331L6.32843 13H17.6708L15.1358 15.535L16.55 16.9493L21.5 11.9996L16.5503 7.0498L15.136 8.46402L17.6721 11H6.32843L8.86396 8.46451L7.44975 7.05029Z"/>',"expand-width":'<path d="M2 6L2 18H4L4 6H2ZM9.44975 7.05025L4.5 12L9.44727 16.9473L9.44826 13H14.5501L14.55 16.9492L19.5 11.9995L14.5503 7.04976L14.5502 11H9.44876L9.44975 7.05025ZM20 6H22V18H20V6Z"/>',"editor-mode":'<path d="M16.7574 2.99678L14.7574 4.99678H5V18.9968H19V9.23943L21 7.23943V19.9968C21 20.5491 20.5523 20.9968 20 20.9968H4C3.44772 20.9968 3 20.5491 3 19.9968V3.99678C3 3.4445 3.44772 2.99678 4 2.99678H16.7574ZM20.4853 2.09729L21.8995 3.5115L12.7071 12.7039L11.2954 12.7064L11.2929 11.2897L20.4853 2.09729Z"/>',legal:'<path d="M12.9985 2L12.9979 3.278L17.9985 4.94591L21.631 3.73509L22.2634 5.63246L19.2319 6.643L22.3272 15.1549C21.2353 16.2921 19.6996 17 17.9985 17C16.2975 17 14.7618 16.2921 13.6699 15.1549L16.7639 6.643L12.9979 5.387V19H16.9985V21H6.99854V19H10.9979V5.387L7.23192 6.643L10.3272 15.1549C9.23528 16.2921 7.69957 17 5.99854 17C4.2975 17 2.76179 16.2921 1.66992 15.1549L4.76392 6.643L1.73363 5.63246L2.36608 3.73509L5.99854 4.94591L10.9979 3.278L10.9985 2H12.9985ZM17.9985 9.10267L16.04 14.4892C16.628 14.8201 17.2979 15 17.9985 15C18.6992 15 19.3691 14.8201 19.957 14.4892L17.9985 9.10267ZM5.99854 9.10267L4.04004 14.4892C4.62795 14.8201 5.29792 15 5.99854 15C6.69916 15 7.36912 14.8201 7.95703 14.4892L5.99854 9.10267Z"/>',featurelist:'<path d="M13 4H21V6H13V4ZM13 11H21V13H13V11ZM13 18H21V20H13V18ZM6.5 19C5.39543 19 4.5 18.1046 4.5 17C4.5 15.8954 5.39543 15 6.5 15C7.60457 15 8.5 15.8954 8.5 17C8.5 18.1046 7.60457 19 6.5 19ZM6.5 21C8.70914 21 10.5 19.2091 10.5 17C10.5 14.7909 8.70914 13 6.5 13C4.29086 13 2.5 14.7909 2.5 17C2.5 19.2091 4.29086 21 6.5 21ZM5 6V9H8V6H5ZM3 4H10V11H3V4Z"/>',cardlets:'<path d="M3 4C3 3.44772 3.44772 3 4 3H10C10.5523 3 11 3.44772 11 4V10C11 10.5523 10.5523 11 10 11H4C3.44772 11 3 10.5523 3 10V4ZM3 14C3 13.4477 3.44772 13 4 13H10C10.5523 13 11 13.4477 11 14V20C11 20.5523 10.5523 21 10 21H4C3.44772 21 3 20.5523 3 20V14ZM13 4C13 3.44772 13.4477 3 14 3H20C20.5523 3 21 3.44772 21 4V10C21 10.5523 20.5523 11 20 11H14C13.4477 11 13 10.5523 13 10V4ZM13 14C13 13.4477 13.4477 13 14 13H20C20.5523 13 21 13.4477 21 14V20C21 20.5523 20.5523 21 20 21H14C13.4477 21 13 20.5523 13 20V14ZM15 5V9H19V5H15ZM15 15V19H19V15H15ZM5 5V9H9V5H5ZM5 15V19H9V15H5Z"/>',faq:'<path d="M5.45455 15L1 18.5V3C1 2.44772 1.44772 2 2 2H17C17.5523 2 18 2.44772 18 3V15H5.45455ZM4.76282 13H16V4H3V14.3851L4.76282 13ZM8 17H18.2372L20 18.3851V8H21C21.5523 8 22 8.44772 22 9V22.5L17.5455 19H9C8.44772 19 8 18.5523 8 18V17Z"/>',definitionlist:'<path d="M8 4H21V6H8V4ZM3 3.5H6V6.5H3V3.5ZM3 10.5H6V13.5H3V10.5ZM3 17.5H6V20.5H3V17.5ZM8 11H21V13H8V11ZM8 18H21V20H8V18Z"/>',item:'<path d="M4 3H20C20.5523 3 21 3.44772 21 4V20C21 20.5523 20.5523 21 20 21H4C3.44772 21 3 20.5523 3 20V4C3 3.44772 3.44772 3 4 3ZM5 5V19H19V5H5ZM11.0026 16L6.75999 11.7574L8.17421 10.3431L11.0026 13.1716L16.6595 7.51472L18.0737 8.92893L11.0026 16Z"/>',"align-left":'<path transform="rotate(-90 12 12)" d="M3 3H21V5H3V3ZM8 11V21H6V11H3L7 7L11 11H8ZM18 11V21H16V11H13L17 7L21 11H18Z"/>',"align-right":'<path transform="rotate(90 12 12)" d="M3 3H21V5H3V3ZM8 11V21H6V11H3L7 7L11 11H8ZM18 11V21H16V11H13L17 7L21 11H18Z"/>',"textsize-normal":'<path d="M10 6V21H8V6H2V4H16V6H10ZM18 14V21H16V14H13V12H21V14H18Z"/>',"textsize-large":'<path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z"/>',"textsize-xlarge":'<path d="M13.0001 10.9999L22.0002 10.9997L22.0002 12.9997L13.0001 12.9999L13.0001 21.9998L11.0001 21.9998L11.0001 12.9999L2.00004 13.0001L2 11.0001L11.0001 10.9999L11 2.00025L13 2.00024L13.0001 10.9999Z"/>',"shared-block":'<path d="M12 2.58582L18.2071 8.79292L16.7929 10.2071L13 6.41424V16H11V6.41424L7.20711 10.2071L5.79289 8.79292L12 2.58582ZM3 18V14H5V18C5 18.5523 5.44772 19 6 19H18C18.5523 19 19 18.5523 19 18V14H21V18C21 19.6569 19.6569 21 18 21H6C4.34315 21 3 19.6569 3 18Z"/>'}})})();
