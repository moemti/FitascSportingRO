
/* Smart UI v11.0.0 (2021-11-30) 
Copyright (c) 2011-2021 jQWidgets. 
License: https://htmlelements.com/license/ */ //

Smart("smart-number-input",class extends Smart.Input{template(){return'<div id="inputContainer" role="presentation"><input class="smart-input" id=\'input\' readonly=\'[[readonly]]\' placeholder=\'[[placeholder]]\' type=\'[[type]]\' name=\'[[name]]\' disabled=\'[[disabled]]\' aria-label="[[placeholder]]" /><span class="smart-hidden smart-hint" id="span">[[hint]]</span><div id="dropDownButton" tabindex=-1 class="nav smart-drop-down-button" role="button" aria-label="Toggle popup"></div></div>'}static get properties(){return{numberFormat:{value:{},type:"any"},min:{value:-9999999999,type:"number"},max:{value:9999999999,type:"number"},step:{value:1,type:"number"},value:{value:0,type:"any"}}}static get listeners(){return{"input.change":"_changeHandler","input.keydown":"_keyDownHandler","input.keyup":"_keyUpHandler"}}getFormattedValue(e,t){return null===t?parseFloat(e):null===e?"":("{}"===JSON.stringify(t)&&(t={style:"decimal"}),Smart.Utilities.Core.Browser.Safari&&"unit"===t.style&&(t.style="decimal"),new Intl.NumberFormat(this.locale,t).format(""+e))}setValue(e){this.value=e}getValue(){return this.value}render(){const e=this;super.render(),e.context=e,e.classList.add("smart-input");const t=e.$.input,n=document.createElement("div"),a=document.createElement("div");t.value=null!==e.value?e.getFormattedValue(Math.min(Math.max(e.min,e.value),e.max),e.numberFormat):"",n.tabIndex=a.tabIndex=-1,t.classList.add("smart-input"),n.classList.add("up"),a.classList.add("down");const l=function(l){if(l&&l.ctrlKey&&"ArrowDown"===l.key)a.click();else if(l&&l.ctrlKey&&"ArrowUp"===l.key)n.click();else if("keydown"!==l.type);else{let n=t.value.toString(),a=1.1;a=a.toLocaleString(e.locale).substring(1,2);const s=n.indexOf(a);if(l.keyCode>=65&&l.keyCode<=90){if(l.ctrlKey)return;return l.stopPropagation(),void l.preventDefault()}if(" "===l.key)return l.stopPropagation(),void l.preventDefault();if("-"===l.key){const e=r();return o(-e),l.stopPropagation(),void l.preventDefault()}switch(l.key){case"'":case'"':case"/":case"\\":case"`":case"=":case"(":case")":return l.stopPropagation(),void l.preventDefault()}if(","===l.key&&","!==a||"."===l.key&&"."!==a)return l.stopPropagation(),void l.preventDefault();const i=[...n];let u=i[t.selectionStart];if((u===a||void 0===u||-1===s)&&l.keyCode>=48&&l.keyCode<=57&&"0"===i[t.selectionStart-1]){const n=e.getFormattedValue(r(),e.numberFormat),a=t.selectionStart-1;(s>=0||-1===s&&0===r())&&t.value.length===n.length&&(t.value=n.substring(0,t.selectionStart-1)+n.substring(t.selectionStart),t.selectionStart=t.selectionEnd=a)}if(l.key===a){if(-1===e.getFormattedValue(r(),e.numberFormat).indexOf(a))return l.stopPropagation(),void l.preventDefault();if(s>=0)return l.stopPropagation(),l.preventDefault(),void(t.selectionStart=t.selectionEnd=s+1)}else if(l.keyCode>=48&&l.keyCode<=57&&t.selectionStart<s&&t.selectionEnd-t.selectionStart<=1){if(isNaN(parseInt(u)))for(let e=t.selectionStart;e<i.length;e++){let n=parseInt(i[e]);if(!isNaN(n)){t.selectionStart=t.selectionEnd=e;break}}}else{if(s>=0&&t.selectionStart>s&&l.keyCode>=48&&l.keyCode<=57){const n=t.selectionStart,o=e.getFormattedValue(r(),e.numberFormat);let i=0;if(o&&-1!==o.indexOf(a))for(let e=o.indexOf(a);e<o.length;e++)!isNaN(parseInt(o.substring(e,e+1)))&&i++;let u=t.value.toString();return u=u.substring(0,t.selectionStart)+l.key.toString()+u.substring(t.selectionStart+1),u.substring(s+1,s+1+i).length<=i&&t.selectionStart<=s+i&&(t.value=u,t.selectionStart=t.selectionEnd=n+1),e._oldValue=e.getValue(),l.stopPropagation(),void l.preventDefault()}if("Backspace"===l.key||"Delete"===l.key){const n=t.selectionStart,o=s>=0&&t.selectionStart>s,i=e.getFormattedValue(r(),e.numberFormat);let u=0;if(i&&-1!==i.indexOf(a))for(let e=i.indexOf(a);e<i.length;e++)!isNaN(parseInt(i.substring(e,e+1)))&&u++;let c=t.value.toString(),d=!1;if("Delete"===l.key&&t.selectionStart<=s+u){c=c.substring(0,t.selectionStart)+"0"+c.substring(t.selectionStart+1);const e=c.substring(s+1,s+1+u);-1===c.indexOf(a)&&s>=0?(t.selectionStart=t.selectionEnd=n+1,d=!0):o&&e.length<=u&&(t.value=c,t.selectionStart=t.selectionEnd=n+1,d=!0)}else if("Backspace"===l.key){c=c.substring(0,t.selectionStart-1)+"0"+c.substring(t.selectionStart);const e=c.substring(s+1,s+1+u);-1===c.indexOf(a)&&s>=0?(t.selectionStart=t.selectionEnd=n-1,d=!0):o&&e.length<=u&&(t.value=c,t.selectionStart=t.selectionEnd=n-1,d=!0)}return e._oldValue=e.getValue(),void(d&&(l.stopPropagation(),l.preventDefault()))}}}};e.$.dropDownButton.appendChild(n),e.$.dropDownButton.appendChild(a),e.dropDownButtonPosition="right";const r=function(){let n=t.value;if(""===n)return null;let a=1.1;a=a.toLocaleString(e.locale).substring(1,2);let l=!1;n.indexOf("(")>=0&&(l=!0,n=n.replace("(","").replace(")",""));let r=[...n],o="";for(let e=0;e<r.length;e++){const t=r[e];switch(t===a&&(o+=t),t){case"0":case"1":case"2":case"3":case"4":case"5":case"6":case"7":case"8":case"9":case"-":o+=t}}o=o.replace(a,"."),n=o;let s=parseFloat(n);return e.numberFormat&&e.numberFormat.style&&"percent"===e.numberFormat.style&&(s/=100),l&&(s=-s),isNaN(s)||s===1/0||s===-1/0?0:(s=Math.min(Math.max(e.min,s),e.max),e._number=s,s)};e.getValue=r;const o=function(n){const a=parseFloat(n);if("-"===n){const n=r();return o(-n),void(e._preventFocus||(t.selectionStart=t.selectionEnd=1,t.selectionEnd=t.value.length))}if(!isNaN(a)){if(e.numberFormat){let a=parseFloat(n);const l=e.getFormattedValue(a,e.numberFormat),r=isNaN(parseFloat(l.substring(0,1)))?1:0,o=n>0?0:1;t.value=l,e._preventFocus||(t.selectionStart=t.selectionEnd=1+r+o),e._number=a}else t.value=a,e._number=a;"number"==typeof n&&(e._preventFocus||(t.selectionStart=0,t.selectionEnd=t.value.length)),e.set("value",""+e._number,!1)}};e.setValue=o,this._attach=function(){t.addEventListener("keydown",l),n.onkeydown=l,a.onkeydown=l;const o=t=>e.numberFormat?e.getFormattedValue(t,e.numberFormat):t,s=function(e){e.interval&&clearInterval(e.interval),e.timer&&clearTimeout(e.timer),e.interval=e.timer=null,e.removeAttribute("active")},i=t=>{t.onmouseleave=t.onmouseup=()=>{s(t)},t.onpointerdown=()=>{e._captured=!0,t.timer=setTimeout((()=>{t.interval=setInterval((()=>{t.click(),t.setAttribute("active","")}),50)}),100)}};n.onclick=function(){const a=r();if(e._captured||s(n),!isNaN(a)&&(a<e.max||""===e.max)){t.value=o(Math.min(e.max,a+e.step));const n=e.getValue();e.value=n,e.$.fireEvent("change",{value:r(),oldValue:a})}},a.onclick=function(){const n=r();if(e._captured||s(a),!isNaN(n)&&(n>e.min||""===e.min)){t.value=o(Math.max(e.min,n-e.step));const a=e.getValue();e.value=a,e.$.fireEvent("change",{value:r(),oldValue:n})}},i(n),i(a)},e._detach=function(){t.removeEventListener("keydown",l),n.onclick=a.onclick=null,n.onkeydown=a.onkeydown=null},e.setValue(e.getValue(),e.numberFormat),e.context=document}_focusHandler(){super._focusHandler(),this._oldValue=this.getValue()}_keyDownHandler(){}_keyUpHandler(e){const t=this;switch(t._oldValue||(t._oldValue=0),e.keyCode){case 40:case 38:case 16:case 17:case 18:case 9:case 13:case 27:e.stopPropagation(),e.preventDefault();break;default:{const e=t.getValue();t.value=e,t.$.fireEvent("changing",{value:e,oldValue:t._oldValue})}}}_changeHandler(e){const t=this;e.stopPropagation(),t._oldValue||(t._oldValue=0),t._oldValue=t.getFormattedValue(t._oldValue,null);const n=t.getValue();t.value=n,t.$.fireEvent("change",{value:n,oldValue:t._oldValue}),t._oldValue=t.getValue()}_blurHandler(){const e=this;super._blurHandler(),e._preventFocus=!0,e.setValue(e.getValue(),e.numberFormat),e._preventFocus=!1}attached(){this._attach()}detached(){this._detach()}_documentUpHandler(e){this._captured=!1,super._documentUpHandler(e)}propertyChangedHandler(e,t,n){const a=this;super.propertyChangedHandler(e,t,n),"locale"===e&&a.setValue(a._number||a.getValue(),a.numberFormat),"value"!==e&&"numberFormat"!==e&&"max"!==e&&"min"!==e||a.setValue(a.getValue(),a.numberFormat)}});