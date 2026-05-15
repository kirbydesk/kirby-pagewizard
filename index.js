(function(){"use strict";function l(e,t,s,n,i,a,c,d){var r=typeof e=="function"?e.options:e;return t&&(r.render=t,r.staticRenderFns=s,r._compiled=!0),a&&(r._scopeId="data-v-"+a),{exports:e,options:r}}const u={};var h=function(){var t=this,s=t._self._c;return s("div",{staticClass:"pwPreview",on:{dblclick:t.open}},[t.content.name?s("div",{staticClass:"heading"},[t._v(" "+t._s(t.content.name)+" ")]):s("div",{staticClass:"heading placeholder"},[t._v(" "+t._s(t.$t("pw.footer.name"))+" ... ")]),t._l(t.content.blocks,function(n){return s("div",{key:n.id,staticClass:"items"},[s("div",{staticClass:"linktext",class:{placeholder:!n.content.linktext}},[s("span",[t._v(t._s(n.content.linktext||t.$t("pw.field.link-text.placeholder")))]),n.content.linktarget?s("span",{staticClass:"k-icon"},[s("k-icon",{attrs:{type:"open"}})],1):t._e()])])})],2)},w=[],f=l(u,h,w,!1,null,"c4342998");const v=f.exports,g={};var k=function(){var t=this,s=t._self._c;return s("div",{staticClass:"pwPreview",on:{dblclick:t.open}},[t.content.linktext?s("div",{staticClass:"linktext"},[s("span",[t._v(t._s(t.content.linktext))]),t.content.linktarget?s("span",{staticClass:"k-icon"},[s("k-icon",{attrs:{type:"open"}})],1):t._e()]):s("div",{staticClass:"placeholder"},[t._v(" "+t._s(t.$t("pw.field.link-text.placeholder"))+" ")])])},b=[],m=l(g,k,b,!1,null,"4929f93f");const x=m.exports,H={data(){return{sharedItems:[]}},computed:{label(){const e=this.sharedItems.find(t=>t.value===this.content.sharedid);return(e==null?void 0:e.label)||this.content.sharedid||""},icon(){const e=this.sharedItems.find(t=>t.value===this.content.sharedid);return(e==null?void 0:e.icon)||null},blockName(){const e=this.sharedItems.find(t=>t.value===this.content.sharedid);return(e==null?void 0:e.name)||""}},async created(){try{const e=await this.$api.get("pagewizard/shared");this.sharedItems=Array.isArray(e)?e:[]}catch{this.sharedItems=[]}}};var L=function(){var t=this,s=t._self._c;return s("div",{staticClass:"pwPreview",attrs:{"data-kirbyblock":"shared"},on:{dblclick:t.open}},[s("div",{staticClass:"shared"},[s("div",{staticClass:"name"},[t.icon?s("k-icon",{attrs:{type:t.icon}}):t._e(),s("span",{staticClass:"blockname"},[t._v(t._s(t.blockName))])],1),s("span",[t._v("|")]),s("em",{staticClass:"sharedname"},[t._v(t._s(t.label))])])])},V=[],y=l(H,L,V,!1,null,"7d2e055d");const _=y.exports,C={props:{content:{type:Object,default:()=>({})},alignDefault:{type:String,default:"left"}},computed:{align(){return this.content.buttonalignment||this.alignDefault},isExternal(){return this.content.linktype==!0&&this.content.linktarget==!0}}};var M=function(){var n;var t=this,s=t._self._c;return s("div",{staticClass:"pwButton",attrs:{"data-align":t.align}},[s("button",{staticClass:"k-button",attrs:{"data-has-text":"true","data-responsive":"true","data-size":"sm","data-variant":"filled",type:"button"}},[(n=t.content.linktext)!=null&&n.length?s("span",{staticClass:"k-button-text",domProps:{innerHTML:t._s(t.content.linktext)}}):s("span",{staticClass:"k-button-text placeholder"},[t._v(" "+t._s(t.$t("pw.field.link-text.placeholder"))+" ")]),t.isExternal?s("svg",{staticClass:"pw-external-icon",attrs:{"aria-hidden":"true",viewBox:"0 0 24 24",fill:"currentColor"}},[s("path",{attrs:{d:"M10 6V8H5V19H16V14H18V20C18 20.5523 17.5523 21 17 21H4C3.44772 21 3 20.5523 3 20V7C3 6.44772 3.44772 6 4 6H10ZM21 3V11H19L18.9999 6.413L11.2071 14.2071L9.79289 12.7929L17.5849 5H13V3H21Z"}})]):t._e()])])},z=[],D=l(C,M,z,!1,null,"48848b4f");const S=D.exports,$={props:{value:String,align:{type:String,default:"left"}}};var Z=function(){var t=this,s=t._self._c;return t.value&&t.value.length?s("div",{staticClass:"k-button-group",attrs:{"data-align":t.align}},t._l(t.value,function(n){return s("div",{key:n.id,class:{ishidden:n.isHidden}},[s("button",{staticClass:"k-button",attrs:{type:"button","data-has-text":"true","data-responsive":"true","data-size":"md","data-variant":"filled"}},[n.content.linktext.length?s("span",{staticClass:"k-button-text"},[t._v(" "+t._s(n.content.linktext)+" ")]):s("span",{staticClass:"k-button-text placeholder"},[t._v(" "+t._s(t.$t("pw.field.link-text.placeholder"))+" ")]),n.content.linktype==!0&&n.content.linktarget==!0?s("svg",{staticClass:"pw-external-icon",attrs:{"aria-hidden":"true",viewBox:"0 0 24 24",fill:"currentColor"}},[s("path",{attrs:{d:"M10 6V8H5V19H16V14H18V20C18 20.5523 17.5523 21 17 21H4C3.44772 21 3 20.5523 3 20V7C3 6.44772 3.44772 6 4 6H10ZM21 3V11H19L18.9999 6.413L11.2071 14.2071L9.79289 12.7929L17.5849 5H13V3H21Z"}})]):t._e()])])}),0):t._e()},A=[],E=l($,Z,A,!1,null,"d0126897");const T=E.exports,O={props:{label:String,help:String},computed:{translatedLabel(){return this.$t(this.label,this.label)},dataTheme(){return this.$attrs["data-theme"]||null}},template:`
		<header class="k-headline-field" :data-theme="dataTheme">
			<h2 class="k-headline" v-html="translatedLabel"></h2>
			<footer v-if="help" class="k-field-footer">
				<div class="k-help k-field-help k-text" v-html="help"></div>
			</footer>
		</header>
	`},I={extends:"k-text-field",props:{label:String,help:String,placeholder:String,value:String,align:String,level:String,size:String,textbackground:String,alignOptions:{default:null},levelOptions:{default:null},sizeOptions:{type:Array,default:null},textbackgroundOptions:{type:Array,default:null}},data(){return{currentAlign:this.parseValue().align||this.align||"left",currentLevel:this.parseValue().level||this.level||"h2",currentSize:this.parseValue().size||this.size||"2xl",currentTextbackground:this.parseValue().textbackground||this.textbackground||null,showAlignDropdown:!1,showLevelDropdown:!1,showSizeDropdown:!1,showTextbackgroundDropdown:!1}},watch:{value(e){const t=this.parseValue();t.align&&(this.currentAlign=t.align),t.level&&(this.currentLevel=t.level),t.size&&(this.currentSize=t.size),t.textbackground&&(this.currentTextbackground=t.textbackground)}},methods:{parseValue(){if(!this.value)return{};try{return typeof this.value=="string"?JSON.parse(this.value):this.value}catch{return{text:this.value}}},emitValue(e,t,s,n,i){const a={text:e,align:t,level:s,size:n};i&&(a.textbackground=i),this.$emit("input",JSON.stringify(a))},updateAlign(e){this.currentAlign=e,this.showAlignDropdown=!1;const t=this.parseValue();this.emitValue(t.text||"",e,t.level||this.currentLevel,t.size||this.currentSize,this.currentTextbackground)},updateLevel(e){this.currentLevel=e,this.showLevelDropdown=!1;const t=this.parseValue();this.emitValue(t.text||"",t.align||this.currentAlign,e,t.size||this.currentSize,this.currentTextbackground)},updateSize(e){this.currentSize=e,this.showSizeDropdown=!1;const t=this.parseValue();this.emitValue(t.text||"",t.align||this.currentAlign,t.level||this.currentLevel,e,this.currentTextbackground)},updateTextbackground(e){this.currentTextbackground=e,this.showTextbackgroundDropdown=!1;const t=this.parseValue();this.emitValue(t.text||"",t.align||this.currentAlign,t.level||this.currentLevel,t.size||this.currentSize,e)},handleInput(e){this.emitValue(e.target.value,this.currentAlign,this.currentLevel,this.currentSize,this.currentTextbackground)},closeDropdowns(){this.showAlignDropdown=!1,this.showLevelDropdown=!1,this.showSizeDropdown=!1,this.showTextbackgroundDropdown=!1},toggleLevelDropdown(){const e=this.showLevelDropdown;this.closeDropdowns(),this.showLevelDropdown=!e},toggleAlignDropdown(){const e=this.showAlignDropdown;this.closeDropdowns(),this.showAlignDropdown=!e},toggleSizeDropdown(){const e=this.showSizeDropdown;this.closeDropdowns(),this.showSizeDropdown=!e},toggleTextbackgroundDropdown(){const e=this.showTextbackgroundDropdown;this.closeDropdowns(),this.showTextbackgroundDropdown=!e},handleClickOutside(e){this.$el.contains(e.target)||this.closeDropdowns()},textbackgroundIcon(e){const t={disabled:'<path d="M9 4.9967V11.2694H7V4.9967H5V13.9967H19V4.9967H9ZM20 15.9967H4V17.9967H20V15.9967ZM3 13.9967V3.9967C3 3.44442 3.44772 2.9967 4 2.9967H20C20.5523 2.9967 21 3.44442 21 3.9967V13.9967H22V18.9967C22 19.549 21.5523 19.9967 21 19.9967H13V22.9967H11V19.9967H3C2.44772 19.9967 2 19.549 2 18.9967V13.9967H3Z"/>',enabled:'<path d="M20 15.9967H4V17.9967H20V15.9967ZM3 13.9967V3.9967C3 3.44442 3.44772 2.9967 4 2.9967H7V11.2694H9V2.9967H20C20.5523 2.9967 21 3.44442 21 3.9967V13.9967H22V18.9967C22 19.549 21.5523 19.9967 21 19.9967H13V22.9967H11V19.9967H3C2.44772 19.9967 2 19.549 2 18.9967V13.9967H3Z"/>'};return t[e]||t.disabled},handleEscape(e){e.key==="Escape"&&(this.showAlignDropdown||this.showLevelDropdown||this.showSizeDropdown||this.showTextbackgroundDropdown)&&(e.stopPropagation(),e.preventDefault(),this.closeDropdowns())},sizeLabel(e){return this.$t("pw.option."+e,e)}},mounted(){this.$nextTick(()=>{document.addEventListener("click",this.handleClickOutside,!0),document.addEventListener("keydown",this.handleEscape)})},beforeDestroy(){document.removeEventListener("click",this.handleClickOutside,!0),document.removeEventListener("keydown",this.handleEscape)},template:`
		<div class="k-field k-text-field" :data-align="currentAlign" :data-level="currentLevel" :data-size="currentSize">
			<header class="k-field-header" style="display:flex;align-items:center;overflow:visible;">
				<label v-if="label" class="k-label k-field-label" style="flex:1;">
					<span class="k-label-text">{{ label }}</span>
				</label>
				<span v-else style="flex:1;"></span>
				<div v-if="(align && alignOptions) || (level && levelOptions) || (size && sizeOptions) || (textbackground && textbackgroundOptions)" class="k-button-group">
					<span v-if="textbackground && textbackgroundOptions" style="position:relative;">
						<button
							data-has-icon="true"
							data-has-text="false"
							aria-label="Text background"
							data-size="xs"
							data-variant="filled"
							type="button"
							class="input-focus k-button"
							@click.stop="toggleTextbackgroundDropdown"
						><span class="k-button-icon"><svg aria-hidden="true" class="k-icon" viewBox="0 0 24 24" fill="currentColor" v-html="textbackgroundIcon(currentTextbackground)"></svg></span></button>
						<dialog v-if="showTextbackgroundDropdown" class="k-dropdown-content pw-dropdown" data-theme="dark" open>
							<div class="k-navigate">
								<button
									v-for="option in textbackgroundOptions"
									:key="option"
									@click.stop="updateTextbackground(option)"
									type="button"
									class="k-button k-dropdown-item"
									data-has-icon="true"
								>
									<span class="k-button-icon"><svg class="k-icon" viewBox="0 0 24 24" fill="currentColor" v-html="textbackgroundIcon(option)"></svg></span>
								</button>
							</div>
						</dialog>
					</span>
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
	`},N={props:{value:String,label:String,placeholder:String,fieldHelp:String,align:{type:String,default:"left"},alignOptions:{type:Array,default:()=>["left","center","right"]},size:{type:String,default:null},sizeOptions:{type:Array,default:null},defaultMode:{type:String,default:null},writerModes:{type:Array,default:()=>["textarea","writer","markdown"]},writerMarks:{type:Array,default:()=>["bold","italic","underline","strike","link"]},writerNodes:{type:Array,default:()=>["heading","bulletList","orderedList"]},writerHeadings:{type:Array,default:()=>[2,3,4]},writerToolbar:{type:Object,default:()=>({inline:!1})}},data(){return{current:this.parse(this.value),showModeDropdown:!1,showAlignDropdown:!1,showSizeDropdown:!1,_closeHandler:null,_updating:!1}},watch:{value(e){this._updating||(this.current=this.parse(e))}},computed:{showModeSwitcher(){return this.writerModes.length>=2},translatedLabel(){return this.label||this.$t("pw.field.text")},modeLabel(){return this.$t("pw.field.text-"+this.current.mode,this.current.mode)},translatedHelp(){return this.fieldHelp||this.$t("pw.field.text-"+this.current.mode+".help","")},translatedPlaceholder(){return this.placeholder||this.$t("pw.field.text-"+this.current.mode+".placeholder","")}},methods:{parse(e){const t=this.defaultMode&&this.writerModes.includes(this.defaultMode)?this.defaultMode:this.writerModes[0]||"textarea",s={mode:t,align:this.align,size:this.size,textarea:"",writer:"",markdown:""};if(!e)return s;try{const i=JSON.parse(e);if(i&&typeof i=="object"&&i.mode)return{mode:this.writerModes.includes(i.mode)?i.mode:t,align:i.align||this.align,size:i.size||this.size,textarea:i.textarea||"",writer:i.writer||"",markdown:i.markdown||""}}catch{}return{...s,mode:["textarea","writer","markdown"].includes(e)?e:"textarea"}},emit(){this._updating=!0,this.$emit("input",JSON.stringify(this.current)),this.$nextTick(()=>{this._updating=!1})},setMode(e){this.current={...this.current,mode:e},this.showModeDropdown=!1,this.emit()},setAlign(e){this.current={...this.current,align:e},this.showAlignDropdown=!1,this.emit()},setSize(e){this.current={...this.current,size:e},this.showSizeDropdown=!1,this.emit()},sizeLabel(e){return this.$t("pw.option."+e,e)},onTextInput(e){this.current={...this.current,[this.current.mode]:e.target.value},this.autoResize(e.target),this.emit()},onWriterInput(e){this.current={...this.current,writer:e},this.emit()},autoResize(e){e.style.height="auto",e.style.height=e.scrollHeight+"px"},toggleModeDropdown(){const e=this.showModeDropdown;this.closeAllDropdowns(),this.showModeDropdown=!e},toggleAlignDropdown(){const e=this.showAlignDropdown;this.closeAllDropdowns(),this.showAlignDropdown=!e},toggleSizeDropdown(){const e=this.showSizeDropdown;this.closeAllDropdowns(),this.showSizeDropdown=!e},closeAllDropdowns(){this.showModeDropdown=!1,this.showAlignDropdown=!1,this.showSizeDropdown=!1},handleClose(e){this.$el.contains(e.target)||this.closeAllDropdowns()}},mounted(){this._closeHandler=this.handleClose,document.addEventListener("click",this._closeHandler,!0),this.$nextTick(()=>{const e=this.$el.querySelector("textarea");e&&this.autoResize(e)})},beforeDestroy(){document.removeEventListener("click",this._closeHandler,!0)},template:`
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
	`},B={props:{value:String,align:{type:String,default:"left"},alignOptions:{type:Array,default:()=>["left","center","right"]},alwaysVisible:{type:Boolean,default:!1}},data(){return{current:this.value||this.align,show:!1,btnEl:null,dropdownEl:null,container:null,_closeHandler:null,_observer:null,_nextColumn:null}},watch:{value(e){this.current=e||this.align,this.updateIcon()}},mounted(){!this.value&&this.current&&this.$emit("input",this.current),this.$nextTick(()=>{const e=this.$el.closest(".k-column");e&&(e.style.display="none");const t=e==null?void 0:e.nextElementSibling,s=t==null?void 0:t.querySelector(".k-field-header");if(!s)return;this.container=document.createElement("span"),this.container.className="pw-align-btn",this.container.style.cssText="position:relative;display:flex;align-items:center;",this.btnEl=document.createElement("button"),this.btnEl.type="button",this.btnEl.className="input-focus k-button",this.btnEl.setAttribute("data-has-icon","true"),this.btnEl.setAttribute("data-has-text","false"),this.btnEl.setAttribute("data-size","xs"),this.btnEl.setAttribute("data-variant","filled"),this.btnEl.setAttribute("aria-label","Align"),this.updateIcon(),this.container.appendChild(this.btnEl),this.btnEl.addEventListener("click",i=>{i.stopPropagation(),this.toggleDropdown()}),this._closeHandler=i=>{this.container.contains(i.target)||this.closeDropdown()},document.addEventListener("click",this._closeHandler);const n=s.querySelector(".k-button");n&&n.parentElement!==s?n.parentElement.prepend(this.container):n?s.insertBefore(this.container,n):s.appendChild(this.container),this._nextColumn=t,this.updateVisibility(),this._observer=new MutationObserver(()=>this.updateVisibility()),this._observer.observe(t,{childList:!0,subtree:!0})})},methods:{updateVisibility(){if(!this.container||!this._nextColumn)return;if(this.alwaysVisible){this.container.style.display="flex";return}const e=this._nextColumn.querySelector(".k-item, .k-block, .k-structure-item")!==null;this.container.style.display=e?"flex":"none"},updateIcon(){if(!this.btnEl)return;const e=this.current||"left";this.btnEl.innerHTML='<span class="k-button-icon"><svg class="k-icon"><use xlink:href="#icon-text-'+e+'"></use></svg></span>'},toggleDropdown(){this.show?this.closeDropdown():this.showDropdown()},showDropdown(){this.dropdownEl&&this.dropdownEl.remove(),this.dropdownEl=document.createElement("dialog"),this.dropdownEl.className="k-dropdown-content pw-dropdown",this.dropdownEl.setAttribute("data-theme","dark"),this.dropdownEl.setAttribute("open","");const e=document.createElement("div");e.className="k-navigate",this.alignOptions.forEach(t=>{const s=document.createElement("button");s.type="button",s.className="k-button k-dropdown-item",s.setAttribute("data-has-icon","true"),s.innerHTML='<span class="k-button-icon"><svg class="k-icon"><use xlink:href="#icon-text-'+t+'"></use></svg></span>',s.addEventListener("click",n=>{n.stopPropagation(),this.select(t)}),e.appendChild(s)}),this.dropdownEl.appendChild(e),this.container.appendChild(this.dropdownEl),this.show=!0},closeDropdown(){this.dropdownEl&&(this.dropdownEl.remove(),this.dropdownEl=null),this.show=!1},select(e){this.current=e,this.updateIcon(),this.closeDropdown(),this.$emit("input",e)}},beforeDestroy(){this._observer&&this._observer.disconnect(),this.container&&this.container.remove(),this._closeHandler&&document.removeEventListener("click",this._closeHandler)},template:'<div style="display:none"></div>'},F={props:{value:String,label:String,help:String,disabled:Boolean},data(){return{current:this.value||"",icons:[],search:"",setName:""}},watch:{value(e){this.current=e||""}},computed:{filtered(){const e=this.search.trim().toLowerCase();return e?this.icons.filter(t=>t.id.toLowerCase().includes(e)):[]},selectedIcon(){return this.current&&this.icons.find(e=>e.svg===this.current)||null},showCount(){return this.search.trim()?this.filtered.length:this.icons.length}},async created(){try{const e=await this.$api.get("pagewizard/config"),t=e["icon-set"];this.setName=e["icon-set-name"]||t;const s=await this.$api.get("pagewizard/icons/"+t);this.icons=Array.isArray(s)?s:[]}catch{this.icons=[]}},methods:{select(e){this.disabled||(this.current=e?e.svg:"",this.$emit("input",this.current))},clear(){this.disabled||(this.current="",this.$emit("input",""))},isActive(e){return this.current===e.svg}},template:`
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
	`},P={extends:"k-text-field",mounted(){this.$nextTick(()=>{var d,r;if(!(((d=this.endpoints)==null?void 0:d.field)||"").includes("/sharedblocks/")){if(this.$el){this.$el.style.display="none";const o=this.$el.closest(".k-column");o&&(o.style.display="none")}return}const s=(r=this.$el)==null?void 0:r.closest(".k-column"),n=s==null?void 0:s.nextElementSibling;n&&(n.style.display="none");const i=new Date,a=o=>String(o).padStart(2,"0"),c=`${i.getFullYear()}-${a(i.getMonth()+1)}-${a(i.getDate())} ${a(i.getHours())}:${a(i.getMinutes())}:${a(i.getSeconds())}`;this.value||(this.$emit("input",c),setTimeout(()=>{var p;const o=(p=this.$el)==null?void 0:p.querySelector("input");o&&(o.style.color="var(--color-gray-500, #999)",o.addEventListener("focus",()=>{o.style.color="",o.value="",this.$emit("input","")},{once:!0}))},0))})}},R={data(){return{sets:[],activeSet:null,icons:[],search:"",copied:null}},computed:{filtered(){const e=this.search.trim().toLowerCase();return e?this.icons.filter(t=>t.id.toLowerCase().includes(e)):this.icons}},async created(){try{if(this.sets=await this.$api.get("pagewizard/icons/sets"),this.sets.length){const e=this.sets.find(t=>t!=="custom")||this.sets[0];await this.loadSet(e)}}catch{}},methods:{async loadSet(e){this.activeSet=e,this.search="";try{const t=await this.$api.get("pagewizard/icons/"+e);this.icons=Array.isArray(t)?t:[]}catch{this.icons=[]}},async copy(e){try{await navigator.clipboard.writeText(e),this.copied=e,setTimeout(()=>{this.copied=null},2e3)}catch{}}}};var q=function(){var t=this,s=t._self._c;return s("k-panel-inside",{staticClass:"pw-icons-view"},[s("k-header",{scopedSlots:t._u([{key:"right",fn:function(){return[s("k-button-group",t._l(t.sets,function(n){return s("k-button",{key:n,attrs:{text:n,theme:t.activeSet===n?"positive":null,variant:"filled",size:"sm"},on:{click:function(i){return t.loadSet(n)}}})}),1)]},proxy:!0}])},[t._v(" "+t._s(t.$t("pw.icon.reference"))+" ")]),s("div",{staticClass:"pw-icons-search"},[s("k-input",{attrs:{type:"text",placeholder:t.$t("pw.icon.search"),value:t.search},on:{input:function(n){t.search=n}}}),s("span",{staticClass:"pw-icons-count"},[t._v(t._s(t.filtered.length)+" / "+t._s(t.icons.length))])],1),s("div",{staticClass:"pw-icons-grid"},t._l(t.filtered,function(n){return s("button",{key:n.id,staticClass:"pw-icons-item",class:{"is-custom":n.custom},attrs:{title:n.id},on:{click:function(i){return t.copy(n.id)}}},[s("span",{staticClass:"pw-icons-svg",domProps:{innerHTML:t._s(n.svg)}}),s("span",{staticClass:"pw-icons-label"},[t._v(t._s(n.id))])])}),0),t.copied?s("k-notification",{attrs:{theme:"positive",type:"alert"}},[t._v(' "'+t._s(t.copied)+'" '+t._s(t.$t("pw.icon.copied"))+" ")]):t._e()],1)},j=[],J=l(R,q,j,!1,null,null);const W=J.exports;panel.plugin("kirbydesk/kirby-pagewizard",{created(){if(!("BroadcastChannel"in window))return;const e=new BroadcastChannel(panel.urls.site);panel.events.on("model.update",()=>{e.postMessage("content/saved")})},blocks:{pwButton:S,pwButtons:T,pwFooter:v,pwFooterItem:x,pwshared:_},fields:{htmlheadline:O,pwtext:I,pweditor:N,pwalign:B,pwicon:F,pwsharedname:P},components:{"pw-icons-view":W},icons:{"align-left":'<path transform="rotate(-90 12 12)" d="M3 3H21V5H3V3ZM8 11V21H6V11H3L7 7L11 11H8ZM18 11V21H16V11H13L17 7L21 11H18Z"/>',"align-right":'<path transform="rotate(90 12 12)" d="M3 3H21V5H3V3ZM8 11V21H6V11H3L7 7L11 11H8ZM18 11V21H16V11H13L17 7L21 11H18Z"/>',cardlets:'<path d="M3 4C3 3.44772 3.44772 3 4 3H10C10.5523 3 11 3.44772 11 4V10C11 10.5523 10.5523 11 10 11H4C3.44772 11 3 10.5523 3 10V4ZM3 14C3 13.4477 3.44772 13 4 13H10C10.5523 13 11 13.4477 11 14V20C11 20.5523 10.5523 21 10 21H4C3.44772 21 3 20.5523 3 20V14ZM13 4C13 3.44772 13.4477 3 14 3H20C20.5523 3 21 3.44772 21 4V10C21 10.5523 20.5523 11 20 11H14C13.4477 11 13 10.5523 13 10V4ZM13 14C13 13.4477 13.4477 13 14 13H20C20.5523 13 21 13.4477 21 14V20C21 20.5523 20.5523 21 20 21H14C13.4477 21 13 20.5523 13 20V14ZM15 5V9H19V5H15ZM15 15V19H19V15H15ZM5 5V9H9V5H5ZM5 15V19H9V15H5Z"/>',customradius:'<path d="M8 3V5H4V9H2V3H8ZM2 21V15H4V19H8V21H2ZM22 21H16V19H20V15H22V21ZM22 9H20V5H16V3H22V9Z"/>',definitionlist:'<path d="M8 4H21V6H8V4ZM3 3.5H6V6.5H3V3.5ZM3 10.5H6V13.5H3V10.5ZM3 17.5H6V20.5H3V17.5ZM8 11H21V13H8V11ZM8 18H21V20H8V18Z"/>',"editor-mode":'<path d="M16.7574 2.99678L14.7574 4.99678H5V18.9968H19V9.23943L21 7.23943V19.9968C21 20.5491 20.5523 20.9968 20 20.9968H4C3.44772 20.9968 3 20.5491 3 19.9968V3.99678C3 3.4445 3.44772 2.99678 4 2.99678H16.7574ZM20.4853 2.09729L21.8995 3.5115L12.7071 12.7039L11.2954 12.7064L11.2929 11.2897L20.4853 2.09729Z"/>',"expand-left":'<path d="M10.071 4.92896L11.4852 6.34317L6.82834 11L16.0002 11.0002L16.0002 13.0002L6.82839 13L11.4852 17.6569L10.071 19.0711L2.99994 12L10.071 4.92896ZM18.0001 19V4.99997H20.0001V19H18.0001Z"/>',"expand-left-right":'<path d="M7.44975 7.05029L2.5 12L7.44727 16.9473L8.86148 15.5331L6.32843 13H17.6708L15.1358 15.535L16.55 16.9493L21.5 11.9996L16.5503 7.0498L15.136 8.46402L17.6721 11H6.32843L8.86396 8.46451L7.44975 7.05029Z"/>',"expand-right":'<path d="M17.1717 11L12.5148 6.34317L13.929 4.92896L21.0001 12L13.929 19.0711L12.5148 17.6569L17.1716 13L7.9998 13.0002L7.99978 11.0002L17.1717 11ZM3.99985 19L3.99985 4.99997H5.99985V19H3.99985Z"/>',"expand-width":'<path d="M2 6L2 18H4L4 6H2ZM9.44975 7.05025L4.5 12L9.44727 16.9473L9.44826 13H14.5501L14.55 16.9492L19.5 11.9995L14.5503 7.04976L14.5502 11H9.44876L9.44975 7.05025ZM20 6H22V18H20V6Z"/>',faq:'<path d="M5.45455 15L1 18.5V3C1 2.44772 1.44772 2 2 2H17C17.5523 2 18 2.44772 18 3V15H5.45455ZM4.76282 13H16V4H3V14.3851L4.76282 13ZM8 17H18.2372L20 18.3851V8H21C21.5523 8 22 8.44772 22 9V22.5L17.5455 19H9C8.44772 19 8 18.5523 8 18V17Z"/>',featurelist:'<path d="M13 4H21V6H13V4ZM13 11H21V13H13V11ZM13 18H21V20H13V18ZM6.5 19C5.39543 19 4.5 18.1046 4.5 17C4.5 15.8954 5.39543 15 6.5 15C7.60457 15 8.5 15.8954 8.5 17C8.5 18.1046 7.60457 19 6.5 19ZM6.5 21C8.70914 21 10.5 19.2091 10.5 17C10.5 14.7909 8.70914 13 6.5 13C4.29086 13 2.5 14.7909 2.5 17C2.5 19.2091 4.29086 21 6.5 21ZM5 6V9H8V6H5ZM3 4H10V11H3V4Z"/>',item:'<path d="M4 3H20C20.5523 3 21 3.44772 21 4V20C21 20.5523 20.5523 21 20 21H4C3.44772 21 3 20.5523 3 20V4C3 3.44772 3.44772 3 4 3ZM5 5V19H19V5H5ZM11.0026 16L6.75999 11.7574L8.17421 10.3431L11.0026 13.1716L16.6595 7.51472L18.0737 8.92893L11.0026 16Z"/>',legal:'<path d="M12.9985 2L12.9979 3.278L17.9985 4.94591L21.631 3.73509L22.2634 5.63246L19.2319 6.643L22.3272 15.1549C21.2353 16.2921 19.6996 17 17.9985 17C16.2975 17 14.7618 16.2921 13.6699 15.1549L16.7639 6.643L12.9979 5.387V19H16.9985V21H6.99854V19H10.9979V5.387L7.23192 6.643L10.3272 15.1549C9.23528 16.2921 7.69957 17 5.99854 17C4.2975 17 2.76179 16.2921 1.66992 15.1549L4.76392 6.643L1.73363 5.63246L2.36608 3.73509L5.99854 4.94591L10.9979 3.278L10.9985 2H12.9985ZM17.9985 9.10267L16.04 14.4892C16.628 14.8201 17.2979 15 17.9985 15C18.6992 15 19.3691 14.8201 19.957 14.4892L17.9985 9.10267ZM5.99854 9.10267L4.04004 14.4892C4.62795 14.8201 5.29792 15 5.99854 15C6.69916 15 7.36912 14.8201 7.95703 14.4892L5.99854 9.10267Z"/>',"shared-block":'<path d="M12 2.58582L18.2071 8.79292L16.7929 10.2071L13 6.41424V16H11V6.41424L7.20711 10.2071L5.79289 8.79292L12 2.58582ZM3 18V14H5V18C5 18.5523 5.44772 19 6 19H18C18.5523 19 19 18.5523 19 18V14H21V18C21 19.6569 19.6569 21 18 21H6C4.34315 21 3 19.6569 3 18Z"/>',"textsize-large":'<path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z"/>',"textsize-normal":'<path d="M10 6V21H8V6H2V4H16V6H10ZM18 14V21H16V14H13V12H21V14H18Z"/>',"textsize-xlarge":'<path d="M13.0001 10.9999L22.0002 10.9997L22.0002 12.9997L13.0001 12.9999L13.0001 21.9998L11.0001 21.9998L11.0001 12.9999L2.00004 13.0001L2 11.0001L11.0001 10.9999L11 2.00025L13 2.00024L13.0001 10.9999Z"/>',"pw-deco-none":'<line x1="6" y1="12" x2="18" y2="12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>',"pw-deco-underline":'<path d="M5 4v8a7 7 0 0 0 14 0V4M5 20h14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>',"pw-deco-arrow":'<path d="M5 12h14M13 5l7 7-7 7" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>',"pw-deco-long-arrow":'<path d="M2 12h19m-5-5l5 5-5 5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>',"pw-deco-chevron":'<polyline points="9 6 15 12 9 18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>',"pw-deco-caret":'<path d="M8 5l8 7-8 7z" fill="currentColor"/>'}})})();
