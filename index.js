(function(){"use strict";function o(e,t,n,s,i,l,Z,$){var a=typeof e=="function"?e.options:e;return t&&(a.render=t,a.staticRenderFns=n,a._compiled=!0),l&&(a._scopeId="data-v-"+l),{exports:e,options:a}}const r={};var d=function(){var t=this,n=t._self._c;return n("div",{staticClass:"pwPreview",on:{dblclick:t.open}},[t.content.name?n("div",{staticClass:"heading"},[t._v(" "+t._s(t.content.name)+" ")]):n("div",{staticClass:"heading placeholder"},[t._v(" "+t._s(t.$t("pw.footer.name"))+" ... ")]),t._l(t.content.blocks,function(s){return n("div",{key:s.id,staticClass:"items"},[n("div",{staticClass:"linktext",class:{placeholder:!s.content.linktext}},[n("span",[t._v(t._s(s.content.linktext||t.$t("pw.field.link-text.placeholder")))]),s.content.linktarget?n("span",{staticClass:"k-icon"},[n("k-icon",{attrs:{type:"open"}})],1):t._e()])])})],2)},c=[],p=o(r,d,c,!1,null,"c4342998");const h=p.exports,u={};var v=function(){var t=this,n=t._self._c;return n("div",{staticClass:"pwPreview",on:{dblclick:t.open}},[t.content.linktext?n("div",{staticClass:"linktext"},[n("span",[t._v(t._s(t.content.linktext))]),t.content.linktarget?n("span",{staticClass:"k-icon"},[n("k-icon",{attrs:{type:"open"}})],1):t._e()]):n("div",{staticClass:"placeholder"},[t._v(" "+t._s(t.$t("pw.field.link-text.placeholder"))+" ")])])},f=[],w=o(u,v,f,!1,null,"4929f93f");const k=w.exports,g={};var b=function(){var t=this,n=t._self._c;return t._self._setupProxy,n("div",{on:{dblclick:t.open}},[n("button",{staticClass:"k-button",attrs:{"data-has-text":"true","data-responsive":"true","data-size":"sm","data-variant":"filled",type:"button"}},[t.content.linktext.length?n("span",{staticClass:"k-button-text",domProps:{innerHTML:t._s(t.content.linktext)},on:{blur:function(s){return t.update({linktext:s.target.innerText})}}}):n("span",{staticClass:"k-button-text placeholder"},[t._v(" "+t._s(t.$t("pw.field.link-text.placeholder"))+" ")])])])},m=[],x=o(g,b,m,!1,null,"67083474");const L=x.exports,_={props:{value:String,align:{type:String,default:"left"}}};var H=function(){var t=this,n=t._self._c;return t.value&&t.value.length?n("div",{staticClass:"k-button-group",attrs:{"data-align":t.align}},t._l(t.value,function(s){return n("div",{key:s.id,class:{ishidden:s.isHidden}},[n("button",{staticClass:"k-button",attrs:{type:"button","data-has-text":"true","data-responsive":"true","data-size":"md","data-variant":"filled"}},[s.content.linktext.length?n("span",{staticClass:"k-button-text"},[t._v(" "+t._s(s.content.linktext)+" ")]):n("span",{staticClass:"k-button-text placeholder"},[t._v(" "+t._s(t.$t("pw.field.link-text.placeholder"))+" ")])])])}),0):t._e()},y=[],V=o(_,H,y,!1,null,"50c67275");const C=V.exports,M={props:{label:String,help:String},computed:{translatedLabel(){return this.$t(this.label,this.label)},dataTheme(){return this.$attrs["data-theme"]||null}},template:`
		<header class="k-headline-field" :data-theme="dataTheme">
			<h2 class="k-headline" v-html="translatedLabel"></h2>
			<footer v-if="help" class="k-field-footer">
				<div class="k-help k-field-help k-text" v-html="help"></div>
			</footer>
		</header>
	`},D={extends:"k-text-field",props:{label:String,help:String,placeholder:String,value:String,align:String,level:String,alignOptions:{type:Array,default:()=>["left","center","right"]},levelOptions:{type:Array,default:()=>["h1","h2","h3","h4"]}},data(){return{currentAlign:this.parseValue().align||this.align||"left",currentLevel:this.parseValue().level||this.level||"h2",showAlignDropdown:!1,showLevelDropdown:!1}},watch:{value(e){const t=this.parseValue();t.align&&(this.currentAlign=t.align),t.level&&(this.currentLevel=t.level)}},methods:{parseValue(){if(!this.value)return{};try{return typeof this.value=="string"?JSON.parse(this.value):this.value}catch{return{text:this.value}}},emitValue(e,t,n){this.$emit("input",JSON.stringify({text:e,align:t,level:n}))},updateAlign(e){this.currentAlign=e,this.showAlignDropdown=!1;const t=this.parseValue();this.emitValue(t.text||"",e,t.level||this.currentLevel)},updateLevel(e){this.currentLevel=e,this.showLevelDropdown=!1;const t=this.parseValue();this.emitValue(t.text||"",t.align||this.currentAlign,e)},handleInput(e){this.emitValue(e.target.value,this.currentAlign,this.currentLevel)},closeDropdowns(){this.showAlignDropdown=!1,this.showLevelDropdown=!1},toggleLevelDropdown(){this.showAlignDropdown=!1,this.showLevelDropdown=!this.showLevelDropdown},toggleAlignDropdown(){this.showLevelDropdown=!1,this.showAlignDropdown=!this.showAlignDropdown},handleClickOutside(e){this.$el.contains(e.target)||this.closeDropdowns()},handleEscape(e){e.key==="Escape"&&(this.showAlignDropdown||this.showLevelDropdown)&&(e.stopPropagation(),e.preventDefault(),this.closeDropdowns())}},mounted(){this.$nextTick(()=>{document.addEventListener("click",this.handleClickOutside,!0),document.addEventListener("keydown",this.handleEscape)})},beforeDestroy(){document.removeEventListener("click",this.handleClickOutside,!0),document.removeEventListener("keydown",this.handleEscape)},template:`
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
	`},A={props:{value:String,label:String,help:String,placeholder:String,writerModes:{type:Array,default:()=>["textarea","writer","markdown"]},writerMarks:{type:Array,default:()=>["bold","italic","underline","strike","link"]},writerNodes:{type:Array,default:()=>["heading","bulletList","orderedList"]},writerHeadings:{type:Array,default:()=>[2,3,4]},writerToolbar:{type:Object,default:()=>({inline:!1})}},data(){return{current:this.parse(this.value),showModeDropdown:!1,showAlignDropdown:!1,_closeHandler:null,_updating:!1}},watch:{value(e){this._updating||(this.current=this.parse(e))}},computed:{showModeSwitcher(){return this.writerModes.length>=2},translatedLabel(){return this.$t("pw.field.text-"+this.current.mode,this.current.mode)},translatedHelp(){return this.$t("pw.field.text-"+this.current.mode+".help","")},translatedPlaceholder(){return this.$t("pw.field.text-"+this.current.mode+".placeholder","")}},methods:{parse(e){const t=this.writerModes[0]||"textarea",n={mode:t,align:"left",textarea:"",writer:"",markdown:""};if(!e)return n;try{const i=JSON.parse(e);if(i&&typeof i=="object"&&i.mode)return{mode:this.writerModes.includes(i.mode)?i.mode:t,align:i.align||"left",textarea:i.textarea||"",writer:i.writer||"",markdown:i.markdown||""}}catch{}return{...n,mode:["textarea","writer","markdown"].includes(e)?e:"textarea"}},emit(){this._updating=!0,this.$emit("input",JSON.stringify(this.current)),this.$nextTick(()=>{this._updating=!1})},setMode(e){this.current={...this.current,mode:e},this.showModeDropdown=!1,this.emit()},setAlign(e){this.current={...this.current,align:e},this.showAlignDropdown=!1,this.emit()},onTextInput(e){this.current={...this.current,[this.current.mode]:e.target.value},this.autoResize(e.target),this.emit()},onWriterInput(e){this.current={...this.current,writer:e},this.emit()},autoResize(e){e.style.height="auto",e.style.height=e.scrollHeight+"px",e.style.minHeight=e.scrollHeight+"px"},toggleModeDropdown(){this.showModeDropdown=!this.showModeDropdown,this.showModeDropdown&&(this.showAlignDropdown=!1)},toggleAlignDropdown(){this.showAlignDropdown=!this.showAlignDropdown,this.showAlignDropdown&&(this.showModeDropdown=!1)},handleClose(e){this.$el.contains(e.target)||(this.showModeDropdown=!1,this.showAlignDropdown=!1)}},mounted(){this._closeHandler=this.handleClose,document.addEventListener("click",this._closeHandler,!0),this.$nextTick(()=>{const e=this.$el.querySelector("textarea");e&&this.autoResize(e)})},beforeDestroy(){document.removeEventListener("click",this._closeHandler,!0)},template:`
		<div class="k-field pw-editor-field">
			<header class="k-field-header" style="display:flex;align-items:center;overflow:visible;">
				<label class="k-label k-field-label" style="flex:1;">
					<span class="k-label-text">{{ $t('pw.field.text') }}</span>
				</label>
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
				@input="onWriterInput"
			></k-input>
			<footer v-if="translatedHelp" class="k-field-footer">
				<div class="k-help k-field-help k-text" v-html="translatedHelp"></div>
			</footer>
		</div>
	`},E={props:{value:String},data(){return{current:this.value||"left",show:!1,btnEl:null,dropdownEl:null,container:null,_closeHandler:null,_observer:null,_nextColumn:null}},watch:{value(e){this.current=e||"left",this.updateIcon()}},mounted(){this.$nextTick(()=>{const e=this.$el.closest(".k-column");e&&(e.style.display="none");const t=e==null?void 0:e.nextElementSibling,n=t==null?void 0:t.querySelector(".k-field-header");if(!n)return;this.container=document.createElement("span"),this.container.className="pw-align-btn",this.container.style.cssText="position:relative;display:flex;align-items:center;",this.btnEl=document.createElement("button"),this.btnEl.type="button",this.btnEl.className="input-focus k-button",this.btnEl.setAttribute("data-has-icon","true"),this.btnEl.setAttribute("data-has-text","false"),this.btnEl.setAttribute("data-size","xs"),this.btnEl.setAttribute("data-variant","filled"),this.btnEl.setAttribute("aria-label","Align"),this.updateIcon(),this.container.appendChild(this.btnEl),this.btnEl.addEventListener("click",i=>{i.stopPropagation(),this.toggleDropdown()}),this._closeHandler=i=>{this.container.contains(i.target)||this.closeDropdown()},document.addEventListener("click",this._closeHandler);const s=n.querySelector(".k-button");s&&s.parentElement!==n?s.parentElement.prepend(this.container):s?n.insertBefore(this.container,s):n.appendChild(this.container),this._nextColumn=t,this.updateVisibility(),this._observer=new MutationObserver(()=>this.updateVisibility()),this._observer.observe(t,{childList:!0,subtree:!0})})},methods:{updateVisibility(){if(!this.container||!this._nextColumn)return;const e=this._nextColumn.querySelector(".k-item, .k-block, .k-structure-item")!==null;this.container.style.display=e?"flex":"none"},updateIcon(){this.btnEl&&(this.btnEl.innerHTML='<span class="k-button-icon"><svg class="k-icon"><use xlink:href="#icon-text-'+this.current+'"></use></svg></span>')},toggleDropdown(){this.show?this.closeDropdown():this.showDropdown()},showDropdown(){this.dropdownEl&&this.dropdownEl.remove(),this.dropdownEl=document.createElement("dialog"),this.dropdownEl.className="k-dropdown-content pw-dropdown",this.dropdownEl.setAttribute("data-theme","dark"),this.dropdownEl.setAttribute("open","");const e=document.createElement("div");e.className="k-navigate",["left","center","right"].forEach(t=>{const n=document.createElement("button");n.type="button",n.className="k-button k-dropdown-item",n.setAttribute("data-has-icon","true"),n.innerHTML='<span class="k-button-icon"><svg class="k-icon"><use xlink:href="#icon-text-'+t+'"></use></svg></span>',n.addEventListener("click",s=>{s.stopPropagation(),this.select(t)}),e.appendChild(n)}),this.dropdownEl.appendChild(e),this.container.appendChild(this.dropdownEl),this.show=!0},closeDropdown(){this.dropdownEl&&(this.dropdownEl.remove(),this.dropdownEl=null),this.show=!1},select(e){this.current=e,this.updateIcon(),this.closeDropdown(),this.$emit("input",e)}},beforeDestroy(){this._observer&&this._observer.disconnect(),this.container&&this.container.remove(),this._closeHandler&&document.removeEventListener("click",this._closeHandler)},template:'<div style="display:none"></div>'};panel.plugin("kirbydesk/kirby-pagewizard",{blocks:{pwButton:L,pwButtons:C,pwFooter:h,pwFooterItem:k},fields:{htmlheadline:M,pwtext:D,pweditor:A,pwalign:E},icons:{"expand-left":'<path d="M10.071 4.92896L11.4852 6.34317L6.82834 11L16.0002 11.0002L16.0002 13.0002L6.82839 13L11.4852 17.6569L10.071 19.0711L2.99994 12L10.071 4.92896ZM18.0001 19V4.99997H20.0001V19H18.0001Z"/>',"expand-right":'<path d="M17.1717 11L12.5148 6.34317L13.929 4.92896L21.0001 12L13.929 19.0711L12.5148 17.6569L17.1716 13L7.9998 13.0002L7.99978 11.0002L17.1717 11ZM3.99985 19L3.99985 4.99997H5.99985V19H3.99985Z"/>',"expand-left-right":'<path d="M7.44975 7.05029L2.5 12L7.44727 16.9473L8.86148 15.5331L6.32843 13H17.6708L15.1358 15.535L16.55 16.9493L21.5 11.9996L16.5503 7.0498L15.136 8.46402L17.6721 11H6.32843L8.86396 8.46451L7.44975 7.05029Z"/>',"expand-width":'<path d="M2 6L2 18H4L4 6H2ZM9.44975 7.05025L4.5 12L9.44727 16.9473L9.44826 13H14.5501L14.55 16.9492L19.5 11.9995L14.5503 7.04976L14.5502 11H9.44876L9.44975 7.05025ZM20 6H22V18H20V6Z"/>',"editor-mode":'<path d="M16.7574 2.99678L14.7574 4.99678H5V18.9968H19V9.23943L21 7.23943V19.9968C21 20.5491 20.5523 20.9968 20 20.9968H4C3.44772 20.9968 3 20.5491 3 19.9968V3.99678C3 3.4445 3.44772 2.99678 4 2.99678H16.7574ZM20.4853 2.09729L21.8995 3.5115L12.7071 12.7039L11.2954 12.7064L11.2929 11.2897L20.4853 2.09729Z"/>',legal:'<path d="M12.9985 2L12.9979 3.278L17.9985 4.94591L21.631 3.73509L22.2634 5.63246L19.2319 6.643L22.3272 15.1549C21.2353 16.2921 19.6996 17 17.9985 17C16.2975 17 14.7618 16.2921 13.6699 15.1549L16.7639 6.643L12.9979 5.387V19H16.9985V21H6.99854V19H10.9979V5.387L7.23192 6.643L10.3272 15.1549C9.23528 16.2921 7.69957 17 5.99854 17C4.2975 17 2.76179 16.2921 1.66992 15.1549L4.76392 6.643L1.73363 5.63246L2.36608 3.73509L5.99854 4.94591L10.9979 3.278L10.9985 2H12.9985ZM17.9985 9.10267L16.04 14.4892C16.628 14.8201 17.2979 15 17.9985 15C18.6992 15 19.3691 14.8201 19.957 14.4892L17.9985 9.10267ZM5.99854 9.10267L4.04004 14.4892C4.62795 14.8201 5.29792 15 5.99854 15C6.69916 15 7.36912 14.8201 7.95703 14.4892L5.99854 9.10267Z"/>',featurelist:'<path d="M13 4H21V6H13V4ZM13 11H21V13H13V11ZM13 18H21V20H13V18ZM6.5 19C5.39543 19 4.5 18.1046 4.5 17C4.5 15.8954 5.39543 15 6.5 15C7.60457 15 8.5 15.8954 8.5 17C8.5 18.1046 7.60457 19 6.5 19ZM6.5 21C8.70914 21 10.5 19.2091 10.5 17C10.5 14.7909 8.70914 13 6.5 13C4.29086 13 2.5 14.7909 2.5 17C2.5 19.2091 4.29086 21 6.5 21ZM5 6V9H8V6H5ZM3 4H10V11H3V4Z"/>',cardlets:'<path d="M3 4C3 3.44772 3.44772 3 4 3H10C10.5523 3 11 3.44772 11 4V10C11 10.5523 10.5523 11 10 11H4C3.44772 11 3 10.5523 3 10V4ZM3 14C3 13.4477 3.44772 13 4 13H10C10.5523 13 11 13.4477 11 14V20C11 20.5523 10.5523 21 10 21H4C3.44772 21 3 20.5523 3 20V14ZM13 4C13 3.44772 13.4477 3 14 3H20C20.5523 3 21 3.44772 21 4V10C21 10.5523 20.5523 11 20 11H14C13.4477 11 13 10.5523 13 10V4ZM13 14C13 13.4477 13.4477 13 14 13H20C20.5523 13 21 13.4477 21 14V20C21 20.5523 20.5523 21 20 21H14C13.4477 21 13 20.5523 13 20V14ZM15 5V9H19V5H15ZM15 15V19H19V15H15ZM5 5V9H9V5H5ZM5 15V19H9V15H5Z"/>',faq:'<path d="M5.45455 15L1 18.5V3C1 2.44772 1.44772 2 2 2H17C17.5523 2 18 2.44772 18 3V15H5.45455ZM4.76282 13H16V4H3V14.3851L4.76282 13ZM8 17H18.2372L20 18.3851V8H21C21.5523 8 22 8.44772 22 9V22.5L17.5455 19H9C8.44772 19 8 18.5523 8 18V17Z"/>',definitionlist:'<path d="M8 4H21V6H8V4ZM3 3.5H6V6.5H3V3.5ZM3 10.5H6V13.5H3V10.5ZM3 17.5H6V20.5H3V17.5ZM8 11H21V13H8V11ZM8 18H21V20H8V18Z"/>'}})})();
