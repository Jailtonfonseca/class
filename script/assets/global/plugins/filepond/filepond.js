/*!
 * FilePond 4.31.1
 * Licensed under MIT, https://opensource.org/licenses/MIT/
 * Please visit https://pqina.nl/filepond/ for details.
 */

/* eslint-disable */

!function(e,t){"object"==typeof exports&&"undefined"!=typeof module?t(exports):"function"==typeof define&&define.amd?define(["exports"],t):t((e=e||self).FilePond={})}(this,function(e){"use strict";var t=function(e,t){for(var n in e)e.hasOwnProperty(n)&&t(n,e[n])},n=function(e){var n={};return t(e,function(t){!function(e,t,n){"function"!=typeof n?Object.defineProperty(e,t,Object.assign({},n)):e[t]=n}(n,t,e[t])}),n},r=function(e,t){var n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:null;if(null===n)return e.getAttribute(t)||e.hasAttribute(t);e.setAttribute(t,n)},o=["svg","path"],i=function(e){return o.includes(e)},a=function(e,n){var o=arguments.length>2&&void 0!==arguments[2]?arguments[2]:{};"object"==typeof n&&(o=n,n=null);var a=i(e)?document.createElementNS("http://www.w3.org/2000/svg",e):document.createElement(e);return n&&(i(e)?r(a,"class",n):a.className=n),t(o,function(e,t){r(a,e,t)}),a},s=function(e,t){return function(e,n){return void 0!==n?t.splice(n,0,e):t.push(e),e}},u=function(e,t){return function(n){return t.splice(t.indexOf(n),1),n.element.parentNode&&e.removeChild(n.element),n}},l="undefined"!=typeof window&&void 0!==window.document,c=function(){return l},f="children"in(c()?a("svg"):{})?function(e){return e.children.length}:function(e){return e.childNodes.length},d=function(e,t,n,r){var o=n[0]||e.left,i=n[1]||e.top,a=o+e.width,s=i+e.height*(r[1]||1),u={element:Object.assign({},e),inner:{left:e.left,top:e.top,right:e.right,bottom:e.bottom},outer:{left:o,top:i,right:a,bottom:s}};return t.filter(function(e){return!e.isRectIgnored()}).map(function(e){return e.rect}).forEach(function(e){p(u.inner,Object.assign({},e.inner)),p(u.outer,Object.assign({},e.outer))}),E(u.inner),u.outer.bottom+=u.element.marginBottom,u.outer.right+=u.element.marginRight,E(u.outer),u},p=function(e,t){t.top+=e.top,t.right+=e.left,t.bottom+=e.top,t.left+=e.left,t.bottom>e.bottom&&(e.bottom=t.bottom),t.right>e.right&&(e.right=t.right)},E=function(e){e.width=e.right-e.left,e.height=e.bottom-e.top},_=function(e){return"number"==typeof e},T=function(e){return e<.5?2*e*e:(4-2*e)*e-1},I={spring:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{},t=e.stiffness,r=void 0===t?.5:t,o=e.damping,i=void 0===o?.75:o,a=e.mass,s=void 0===a?10:a,u=null,l=null,c=0,f=!1,d=n({interpolate:function(e,t){if(!f){if(!_(u)||!_(l))return f=!0,void(c=0);(function(e,t,n){var r=arguments.length>3&&void 0!==arguments[3]?arguments[3]:.001;return Math.abs(e-t)<r&&Math.abs(n)<r})(l+=c+=-(l-u)*r/s,u,c*=i)||t?(l=u,c=0,f=!0,d.onupdate(l),d.oncomplete(l)):d.onupdate(l)}},target:{set:function(e){if(_(e)&&!_(l)&&(l=e),null===u&&(u=e,l=e),l===(u=e)||void 0===u)return f=!0,c=0,d.onupdate(l),void d.oncomplete(l);f=!1},get:function(){return u}},resting:{get:function(){return f}},onupdate:function(e){},oncomplete:function(e){}});return d},tween:function(){var e,t,r=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{},o=r.duration,i=void 0===o?500:o,a=r.easing,s=void 0===a?T:a,u=r.delay,l=void 0===u?0:u,c=null,f=!0,d=!1,p=null,E=n({interpolate:function(n,r){f||null===p||(null===c&&(c=n),n-c<l||((e=n-c-l)>=i||r?(e=1,t=d?0:1,E.onupdate(t*p),E.oncomplete(t*p),f=!0):(t=e/i,E.onupdate((e>=0?s(d?1-t:t):0)*p))))},target:{get:function(){return d?0:p},set:function(e){if(null===p)return p=e,E.onupdate(e),void E.oncomplete(e);e<p?(p=1,d=!0):(d=!1,p=e),f=!1,c=null}},resting:{get:function(){return f}},onupdate:function(e){},oncomplete:function(e){}});return E}},v=function(e,t,n){var r=e[t]&&"object"==typeof e[t][n]?e[t][n]:e[t]||e,o="string"==typeof r?r:r.type,i="object"==typeof r?Object.assign({},r):{};return I[o]?I[o](i):null},m=function(e,t,n){var r=arguments.length>3&&void 0!==arguments[3]&&arguments[3];(t=Array.isArray(t)?t:[t]).forEach(function(t){e.forEach(function(e){var o=e,i=function(){return n[e]},a=function(t){return n[e]=t};"object"==typeof e&&(o=e.key,i=e.getter||i,a=e.setter||a),t[o]&&!r||(t[o]={get:i,set:a})})})},h=function(e){return null!=e},g={opacity:1,scaleX:1,scaleY:1,translateX:0,translateY:0,rotateX:0,rotateY:0,rotateZ:0,originX:0,originY:0},R=function(e,t){if(Object.keys(e).length!==Object.keys(t).length)return!0;for(var n in t)if(t[n]!==e[n])return!0;return!1},O=function(e,t){var n=t.opacity,r=t.perspective,o=t.translateX,i=t.translateY,a=t.scaleX,s=t.scaleY,u=t.rotateX,l=t.rotateY,c=t.rotateZ,f=t.originX,d=t.originY,p=t.width,E=t.height,_="",T="";(h(f)||h(d))&&(T+="transform-origin: "+(f||0)+"px "+(d||0)+"px;"),h(r)&&(_+="perspective("+r+"px) "),(h(o)||h(i))&&(_+="translate3d("+(o||0)+"px, "+(i||0)+"px, 0) "),(h(a)||h(s))&&(_+="scale3d("+(h(a)?a:1)+", "+(h(s)?s:1)+", 1) "),h(c)&&(_+="rotateZ("+c+"rad) "),h(u)&&(_+="rotateX("+u+"rad) "),h(l)&&(_+="rotateY("+l+"rad) "),_.length&&(T+="transform:"+_+";"),h(n)&&(T+="opacity:"+n+";",0===n&&(T+="visibility:hidden;"),n<1&&(T+="pointer-events:none;")),h(E)&&(T+="height:"+E+"px;"),h(p)&&(T+="width:"+p+"px;");var I=e.elementCurrentStyle||"";T.length===I.length&&T===I||(e.style.cssText=T,e.elementCurrentStyle=T)},y={styles:function(e){var t=e.mixinConfig,n=e.viewProps,r=e.viewInternalAPI,o=e.viewExternalAPI,i=e.view,a=Object.assign({},n),s={};m(t,[r,o],n);var u=function(){return i.rect?d(i.rect,i.childViews,[n.translateX||0,n.translateY||0],[n.scaleX||0,n.scaleY||0]):null};return r.rect={get:u},o.rect={get:u},t.forEach(function(e){n[e]=void 0===a[e]?g[e]:a[e]}),{write:function(){if(R(s,n))return O(i.element,n),Object.assign(s,Object.assign({},n)),!0},destroy:function(){}}},listeners:function(e){e.mixinConfig,e.viewProps,e.viewInternalAPI;var t,n=e.viewExternalAPI,r=(e.viewState,e.view),o=[],i=(t=r.element,function(e,n){t.addEventListener(e,n)}),a=function(e){return function(t,n){e.removeEventListener(t,n)}}(r.element);return n.on=function(e,t){o.push({type:e,fn:t}),i(e,t)},n.off=function(e,t){o.splice(o.findIndex(function(n){return n.type===e&&n.fn===t}),1),a(e,t)},{write:function(){return!0},destroy:function(){o.forEach(function(e){a(e.type,e.fn)})}}},animations:function(e){var n=e.mixinConfig,r=e.viewProps,o=e.viewInternalAPI,i=e.viewExternalAPI,a=Object.assign({},r),s=[];return t(n,function(e,t){var n=v(t);n&&(n.onupdate=function(t){r[e]=t},n.target=a[e],m([{key:e,setter:function(e){n.target!==e&&(n.target=e)},getter:function(){return r[e]}}],[o,i],r,!0),s.push(n))}),{write:function(e){var t=document.hidden,n=!0;return s.forEach(function(r){r.resting||(n=!1),r.interpolate(e,t)}),n},destroy:function(){}}},apis:function(e){var t=e.mixinConfig,n=e.viewProps,r=e.viewExternalAPI;m(t,r,n)}},D=function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{},t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{},n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:{};return t.layoutCalculated||(e.paddingTop=parseInt(n.paddingTop,10)||0,e.marginTop=parseInt(n.marginTop,10)||0,e.marginRight=parseInt(n.marginRight,10)||0,e.marginBottom=parseInt(n.marginBottom,10)||0,e.marginLeft=parseInt(n.marginLeft,10)||0,t.layoutCalculated=!0),e.left=t.offsetLeft||0,e.top=t.offsetTop||0,e.width=t.offsetWidth||0,e.height=t.offsetHeight||0,e.right=e.left+e.width,e.bottom=e.top+e.height,e.scrollTop=t.scrollTop,e.hidden=null===t.offsetParent,e},S=function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{},t=e.tag,r=void 0===t?"div":t,o=e.name,i=void 0===o?null:o,l=e.attributes,c=void 0===l?{}:l,p=e.read,E=void 0===p?function(){}:p,_=e.write,T=void 0===_?function(){}:_,I=e.create,v=void 0===I?function(){}:I,m=e.destroy,h=void 0===m?function(){}:m,g=e.filterFrameActionsForChild,R=void 0===g?function(e,t){return t}:g,O=e.didCreateView,S=void 0===O?function(){}:O,A=e.didWriteView,L=void 0===A?function(){}:A,b=e.ignoreRect,P=void 0!==b&&b,M=e.ignoreRectUpdate,w=void 0!==M&&M,C=e.mixins,N=void 0===C?[]:C;return function(e){var t,o=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{},l=a(r,"filepond--"+i,c),p=window.getComputedStyle(l,null),_=D(),I=null,m=!1,g=[],O=[],A={},b={},M=[T],C=[E],G=[h],U=function(){return l},B=function(){return g.concat()},F=function(){return I||(I=d(_,g,[0,0],[1,1]))},q={element:{get:U},style:{get:function(){return p}},childViews:{get:B}},V=Object.assign({},q,{rect:{get:F},ref:{get:function(){return A}},is:function(e){return i===e},appendChild:(t=l,function(e,n){void 0!==n&&t.children[n]?t.insertBefore(e,t.children[n]):t.appendChild(e)}),createChildView:function(e){return function(t,n){return t(e,n)}}(e),linkView:function(e){return g.push(e),e},unlinkView:function(e){g.splice(g.indexOf(e),1)},appendChildView:s(0,g),removeChildView:u(l,g),registerWriter:function(e){return M.push(e)},registerReader:function(e){return C.push(e)},registerDestroyer:function(e){return G.push(e)},invalidateLayout:function(){return l.layoutCalculated=!1},dispatch:e.dispatch,query:e.query}),x={element:{get:U},childViews:{get:B},rect:{get:F},resting:{get:function(){return m}},isRectIgnored:function(){return P},_read:function(){I=null,g.forEach(function(e){return e._read()}),!(w&&_.width&&_.height)&&D(_,l,p);var e={root:k,props:o,rect:_};C.forEach(function(t){return t(e)})},_write:function(e,t,n){var r=0===t.length;return M.forEach(function(i){!1===i({props:o,root:k,actions:t,timestamp:e,shouldOptimize:n})&&(r=!1)}),O.forEach(function(t){!1===t.write(e)&&(r=!1)}),g.filter(function(e){return!!e.element.parentNode}).forEach(function(o){o._write(e,R(o,t),n)||(r=!1)}),g.forEach(function(o,i){o.element.parentNode||(k.appendChild(o.element,i),o._read(),o._write(e,R(o,t),n),r=!1)}),m=r,L({props:o,root:k,actions:t,timestamp:e}),r},_destroy:function(){O.forEach(function(e){return e.destroy()}),G.forEach(function(e){e({root:k,props:o})}),g.forEach(function(e){return e._destroy()})}},Y=Object.assign({},q,{rect:{get:function(){return _}}});Object.keys(N).sort(function(e,t){return"styles"===e?1:"styles"===t?-1:0}).forEach(function(e){var t=y[e]({mixinConfig:N[e],viewProps:o,viewState:b,viewInternalAPI:V,viewExternalAPI:x,view:n(Y)});t&&O.push(t)});var k=n(V);v({root:k,props:o});var j=f(l);return g.forEach(function(e,t){k.appendChild(e.element,j+t)}),S(k),n(x)}},A=function(e,t){return function(n){var r=n.root,o=n.props,i=n.actions,a=void 0===i?[]:i,s=n.timestamp,u=n.shouldOptimize;a.filter(function(t){return e[t.type]}).forEach(function(t){return e[t.type]({root:r,props:o,action:t.data,timestamp:s,shouldOptimize:u})}),t&&t({root:r,props:o,actions:a,timestamp:s,shouldOptimize:u})}},L=function(e,t){return t.parentNode.insertBefore(e,t)},b=function(e,t){return t.parentNode.insertBefore(e,t.nextSibling)},P=function(e){return Array.isArray(e)},M=function(e){return null==e},w=function(e){return e.trim()},C=function(e){return""+e},N=function(e){return"boolean"==typeof e},G=function(e){return N(e)?e:"true"===e},U=function(e){return"string"==typeof e},B=function(e){return _(e)?e:U(e)?C(e).replace(/[a-z]+/gi,""):0},F=function(e){return parseInt(B(e),10)},q=function(e){return parseFloat(B(e))},V=function(e){return _(e)&&isFinite(e)&&Math.floor(e)===e},x=function(e){var t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:1e3;if(V(e))return e;var n=C(e).trim();return/MB$/i.test(n)?(n=n.replace(/MB$i/,"").trim(),F(n)*t*t):/KB/i.test(n)?(n=n.replace(/KB$i/,"").trim(),F(n)*t):F(n)},Y=function(e){return"function"==typeof e},k={process:"POST",patch:"PATCH",revert:"DELETE",fetch:"GET",restore:"GET",load:"GET"},j=function(e,t,n,r,o){if(null===t)return null;if("function"==typeof t)return t;var i={url:"GET"===n||"PATCH"===n?"?"+e+"=":"",method:n,headers:o,withCredentials:!1,timeout:r,onload:null,ondata:null,onerror:null};if(U(t))return i.url=t,i;if(Object.assign(i,t),U(i.headers)){var a=i.headers.split(/:(.+)/);i.headers={header:a[0],value:a[1]}}return i.withCredentials=G(i.withCredentials),i},H=function(e){return"object"==typeof e&&null!==e},X=function(e){return P(e)?"array":function(e){return null===e}(e)?"null":V(e)?"int":/^[0-9]+ ?(?:GB|MB|KB)$/gi.test(e)?"bytes":function(e){return H(e)&&U(e.url)&&H(e.process)&&H(e.revert)&&H(e.restore)&&H(e.fetch)}(e)?"api":typeof e},W={array:function(e){var t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:",";return M(e)?[]:P(e)?e:C(e).split(t).map(w).filter(function(e){return e.length})},boolean:G,int:function(e){return"bytes"===X(e)?x(e):F(e)},number:q,float:q,bytes:x,string:function(e){return Y(e)?e:C(e)},function:function(e){return function(e){for(var t=self,n=e.split("."),r=null;r=n.shift();)if(!(t=t[r]))return null;return t}(e)},serverapi:function(e){return(r={}).url=U(n=e)?n:n.url||"",r.timeout=n.timeout?parseInt(n.timeout,10):0,r.headers=n.headers?n.headers:{},t(k,function(e){r[e]=j(e,n[e],k[e],r.timeout,r.headers)}),r.process=n.process||U(n)||n.url?r.process:null,r.remove=n.remove||null,delete r.headers,r;var n,r},object:function(e){try{return JSON.parse(e.replace(/{\s*'/g,'{"').replace(/'\s*}/g,'"}').replace(/'\s*:/g,'":').replace(/:\s*'/g,':"').replace(/,\s*'/g,',"').replace(/'\s*,/g,'",'))}catch(e){return null}}},z=function(e,t,n){if(e===t)return e;var r,o=X(e);if(o!==n){var i=(r=e,W[n](r));if(o=X(i),null===i)throw'Trying to assign value with incorrect type to "'+option+'", allowed type: "'+n+'"';e=i}return e},Q=function(e){var r={};return t(e,function(t){var n,o,i,a=e[t];r[t]=(n=a[0],o=a[1],i=n,{enumerable:!0,get:function(){return i},set:function(e){i=z(e,n,o)}})}),n(r)},Z=function(e){var t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"-";return e.split(/(?=[A-Z])/).map(function(e){return e.toLowerCase()}).join(t)},K=function(e){return function(n,r,o){var i={};return t(e,function(e){var t=Z(e,"_").toUpperCase();i["SET_"+t]=function(r){try{o.options[e]=r.value}catch(e){}n("DID_SET_"+t,{value:o.options[e]})}}),i}},$=function(e){return function(n){var r={};return t(e,function(e){r["GET_"+Z(e,"_").toUpperCase()]=function(t){return n.options[e]}}),r}},J=1,ee=2,te=3,ne=4,re=5,oe=function(){return Math.random().toString(36).substring(2,11)};function ie(e){this.wrapped=e}function ae(e){var t,n;function r(t,n){try{var i=e[t](n),a=i.value,s=a instanceof ie;Promise.resolve(s?a.wrapped:a).then(function(e){s?r("next",e):o(i.done?"return":"normal",e)},function(e){r("throw",e)})}catch(e){o("throw",e)}}function o(e,o){switch(e){case"return":t.resolve({value:o,done:!0});break;case"throw":t.reject(o);break;default:t.resolve({value:o,done:!1})}(t=t.next)?r(t.key,t.arg):n=null}this._invoke=function(e,o){return new Promise(function(i,a){var s={key:e,arg:o,resolve:i,reject:a,next:null};n?n=n.next=s:(t=n=s,r(e,o))})},"function"!=typeof e.return&&(this.return=void 0)}function se(e,t){if(null==e)return{};var n,r,o=function(e,t){if(null==e)return{};var n,r,o={},i=Object.keys(e);for(r=0;r<i.length;r++)n=i[r],t.indexOf(n)>=0||(o[n]=e[n]);return o}(e,t);if(Object.getOwnPropertySymbols){var i=Object.getOwnPropertySymbols(e);for(r=0;r<i.length;r++)n=i[r],t.indexOf(n)>=0||Object.prototype.propertyIsEnumerable.call(e,n)&&(o[n]=e[n])}return o}"function"==typeof Symbol&&Symbol.asyncIterator&&(ae.prototype[Symbol.asyncIterator]=function(){return this}),ae.prototype.next=function(e){return this._invoke("next",e)},ae.prototype.throw=function(e){return this._invoke("throw",e)},ae.prototype.return=function(e){return this._invoke("return",e)};function ue(e){return function(e){if(Array.isArray(e)){for(var t=0,n=new Array(e.length);t<e.length;t++)n[t]=e[t];return n}}(e)||le(e)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance")}()}function le(e){if(Symbol.iterator in Object(e)||"[object Arguments]"===Object.prototype.toString.call(e))return Array.from(e)}var ce,fe,de=function(e,t){return e.splice(t,1)},pe=function(){var e=[],t=function(t,n){de(e,e.findIndex(function(e){return e.event===t&&(e.cb===n||!n)}))},n=function(t,n,r){e.filter(function(e){return e.event===t}).map(function(e){return e.cb}).forEach(function(e){return function(e,t){t?e():document.hidden?Promise.resolve(1).then(e):setTimeout(e,0)}(function(){return e.apply(void 0,ue(n))},r)})};return{fireSync:function(e){for(var t=arguments.length,r=new Array(t>1?t-1:0),o=1;o<t;o++)r[o-1]=arguments[o];n(e,r,!0)},fire:function(e){for(var t=arguments.length,r=new Array(t>1?t-1:0),o=1;o<t;o++)r[o-1]=arguments[o];n(e,r,!1)},on:function(t,n){e.push({event:t,cb:n})},onOnce:function(n,r){e.push({event:n,cb:function(){t(n,r),r.apply(void 0,arguments)}})},off:t}},Ee=function(e,t,n){Object.getOwnPropertyNames(e).filter(function(e){return!n.includes(e)}).forEach(function(n){return Object.defineProperty(t,n,Object.getOwnPropertyDescriptor(e,n))})},_e=["fire","process","revert","load","on","off","onOnce","retryLoad","extend","archive","archived","release","released","requestProcessing","freeze"],Te=function(e){var t={};return Ee(e,t,_e),t},Ie={INIT:1,IDLE:2,PROCESSING_QUEUED:9,PROCESSING:3,PROCESSING_COMPLETE:5,PROCESSING_ERROR:6,PROCESSING_REVERT_ERROR:10,LOADING:7,LOAD_ERROR:8},ve={INPUT:1,LIMBO:2,LOCAL:3},me=function(e){return/[^0-9]+/.exec(e)},he=function(){return me(1.1.toLocaleString())[0]},ge={BOOLEAN:"boolean",INT:"int",NUMBER:"number",STRING:"string",ARRAY:"array",OBJECT:"object",FUNCTION:"function",ACTION:"action",SERVER_API:"serverapi",REGEX:"regex"},Re=[],Oe=function(e,t,n){return new Promise(function(r,o){var i=Re.filter(function(t){return t.key===e}).map(function(e){return e.cb});if(0!==i.length){var a=i.shift();i.reduce(function(e,t){return e.then(function(e){return t(e,n)})},a(t,n)).then(function(e){return r(e)}).catch(function(e){return o(e)})}else r(t)})},ye=function(e,t,n){return Re.filter(function(t){return t.key===e}).map(function(e){return e.cb(t,n)})},De=function(e,t){return Re.push({key:e,cb:t})},Se=function(){return Object.assign({},Ae)},Ae={id:[null,ge.STRING],name:["filepond",ge.STRING],disabled:[!1,ge.BOOLEAN],className:[null,ge.STRING],required:[!1,ge.BOOLEAN],captureMethod:[null,ge.STRING],allowSyncAcceptAttribute:[!0,ge.BOOLEAN],allowDrop:[!0,ge.BOOLEAN],allowBrowse:[!0,ge.BOOLEAN],allowPaste:[!0,ge.BOOLEAN],allowMultiple:[!1,ge.BOOLEAN],allowReplace:[!0,ge.BOOLEAN],allowRevert:[!0,ge.BOOLEAN],allowRemove:[!0,ge.BOOLEAN],allowProcess:[!0,ge.BOOLEAN],allowReorder:[!1,ge.BOOLEAN],allowDirectoriesOnly:[!1,ge.BOOLEAN],storeAsFile:[!1,ge.BOOLEAN],forceRevert:[!1,ge.BOOLEAN],maxFiles:[null,ge.INT],checkValidity:[!1,ge.BOOLEAN],itemInsertLocationFreedom:[!0,ge.BOOLEAN],itemInsertLocation:["before",ge.STRING],itemInsertInterval:[75,ge.INT],dropOnPage:[!1,ge.BOOLEAN],dropOnElement:[!0,ge.BOOLEAN],dropValidation:[!1,ge.BOOLEAN],ignoredFiles:[[".ds_store","thumbs.db","desktop.ini"],ge.ARRAY],instantUpload:[!0,ge.BOOLEAN],maxParallelUploads:[2,ge.INT],allowMinimumUploadDuration:[!0,ge.BOOLEAN],chunkUploads:[!1,ge.BOOLEAN],chunkForce:[!1,ge.BOOLEAN],chunkSize:[5e6,ge.INT],chunkRetryDelays:[[500,1e3,3e3],ge.ARRAY],server:[null,ge.SERVER_API],fileSizeBase:[1e3,ge.INT],labelFileSizeBytes:["bytes",ge.STRING],labelFileSizeKilobytes:["KB",ge.STRING],labelFileSizeMegabytes:["MB",ge.STRING],labelFileSizeGigabytes:["GB",ge.STRING],labelDecimalSeparator:[he(),ge.STRING],labelThousandsSeparator:[(ce=he(),fe=1e3.toLocaleString(),fe!==1e3.toString()?me(fe)[0]:"."===ce?",":"."),ge.STRING],labelIdle:['Drag & Drop your files or <span class="filepond--label-action">Browse</span>',ge.STRING],labelInvalidField:["Field contains invalid files",ge.STRING],labelFileWaitingForSize:["Waiting for size",ge.STRING],labelFileSizeNotAvailable:["Size not available",ge.STRING],labelFileCountSingular:["file in list",ge.STRING],labelFileCountPlural:["files in list",ge.STRING],labelFileLoading:["Loading",ge.STRING],labelFileAdded:["Added",ge.STRING],labelFileLoadError:["Error during load",ge.STRING],labelFileRemoved:["Removed",ge.STRING],labelFileRemoveError:["Error during remove",ge.STRING],labelFileProcessing:["Uploading",ge.STRING],labelFileProcessingComplete:["Upload complete",ge.STRING],labelFileProcessingAborted:["Upload cancelled",ge.STRING],labelFileProcessingError:["Error during upload",ge.STRING],labelFileProcessingRevertError:["Error during revert",ge.STRING],labelTapToCancel:["tap to cancel",ge.STRING],labelTapToRetry:["tap to retry",ge.STRING],labelTapToUndo:["tap to undo",ge.STRING],labelButtonRemoveItem:["Remove",ge.STRING],labelButtonAbortItemLoad:["Abort",ge.STRING],labelButtonRetryItemLoad:["Retry",ge.STRING],labelButtonAbortItemProcessing:["Cancel",ge.STRING],labelButtonUndoItemProcessing:["Undo",ge.STRING],labelButtonRetryItemProcessing:["Retry",ge.STRING],labelButtonProcessItem:["Upload",ge.STRING],iconRemove:['<svg width="26" height="26" viewBox="0 0 26 26" xmlns="http://www.w3.org/2000/svg"><path d="M11.586 13l-2.293 2.293a1 1 0 0 0 1.414 1.414L13 14.414l2.293 2.293a1 1 0 0 0 1.414-1.414L14.414 13l2.293-2.293a1 1 0 0 0-1.414-1.414L13 11.586l-2.293-2.293a1 1 0 0 0-1.414 1.414L11.586 13z" fill="currentColor" fill-rule="nonzero"/></svg>',ge.STRING],iconProcess:['<svg width="26" height="26" viewBox="0 0 26 26" xmlns="http://www.w3.org/2000/svg"><path d="M14 10.414v3.585a1 1 0 0 1-2 0v-3.585l-1.293 1.293a1 1 0 0 1-1.414-1.415l3-3a1 1 0 0 1 1.414 0l3 3a1 1 0 0 1-1.414 1.415L14 10.414zM9 18a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2H9z" fill="currentColor" fill-rule="evenodd"/></svg>',ge.STRING],iconRetry:['<svg width="26" height="26" viewBox="0 0 26 26" xmlns="http://www.w3.org/2000/svg"><path d="M10.81 9.185l-.038.02A4.997 4.997 0 0 0 8 13.683a5 5 0 0 0 5 5 5 5 0 0 0 5-5 1 1 0 0 1 2 0A7 7 0 1 1 9.722 7.496l-.842-.21a.999.999 0 1 1 .484-1.94l3.23.806c.535.133.86.675.73 1.21l-.804 3.233a.997.997 0 0 1-1.21.73.997.997 0 0 1-.73-1.21l.23-.928v-.002z" fill="currentColor" fill-rule="nonzero"/></svg>',ge.STRING],iconUndo:['<svg width="26" height="26" viewBox="0 0 26 26" xmlns="http://www.w3.org/2000/svg"><path d="M9.185 10.81l.02-.038A4.997 4.997 0 0 1 13.683 8a5 5 0 0 1 5 5 5 5 0 0 1-5 5 1 1 0 0 0 0 2A7 7 0 1 0 7.496 9.722l-.21-.842a.999.999 0 1 0-1.94.484l.806 3.23c.133.535.675.86 1.21.73l3.233-.803a.997.997 0 0 0 .73-1.21.997.997 0 0 0-1.21-.73l-.928.23-.002-.001z" fill="currentColor" fill-rule="nonzero"/></svg>',ge.STRING],iconDone:['<svg width="26" height="26" viewBox="0 0 26 26" xmlns="http://www.w3.org/2000/svg"><path d="M18.293 9.293a1 1 0 0 1 1.414 1.414l-7.002 7a1 1 0 0 1-1.414 0l-3.998-4a1 1 0 1 1 1.414-1.414L12 15.586l6.294-6.293z" fill="currentColor" fill-rule="nonzero"/></svg>',ge.STRING],oninit:[null,ge.FUNCTION],onwarning:[null,ge.FUNCTION],onerror:[null,ge.FUNCTION],onactivatefile:[null,ge.FUNCTION],oninitfile:[null,ge.FUNCTION],onaddfilestart:[null,ge.FUNCTION],onaddfileprogress:[null,ge.FUNCTION],onaddfile:[null,ge.FUNCTION],onprocessfilestart:[null,ge.FUNCTION],onprocessfileprogress:[null,ge.FUNCTION],onprocessfileabort:[null,ge.FUNCTION],onprocessfilerevert:[null,ge.FUNCTION],onprocessfile:[null,ge.FUNCTION],onprocessfiles:[null,ge.FUNCTION],onremovefile:[null,ge.FUNCTION],onpreparefile:[null,ge.FUNCTION],onupdatefiles:[null,ge.FUNCTION],onreorderfiles:[null,ge.FUNCTION],beforeDropFile:[null,ge.FUNCTION],beforeAddFile:[null,ge.FUNCTION],beforeRemoveFile:[null,ge.FUNCTION],beforePrepareFile:[null,ge.FUNCTION],stylePanelLayout:[null,ge.STRING],stylePanelAspectRatio:[null,ge.STRING],styleItemPanelAspectRatio:[null,ge.STRING],styleButtonRemoveItemPosition:["left",ge.STRING],styleButtonProcessItemPosition:["right",ge.STRING],styleLoadIndicatorPosition:["right",ge.STRING],styleProgressIndicatorPosition:["right",ge.STRING],styleButtonRemoveItemAlign:[!1,ge.BOOLEAN],files:[[],ge.ARRAY],credits:[["https://pqina.nl/","Powered by PQINA"],ge.ARRAY]},Le=function(e,t){return M(t)?e[0]||null:V(t)?e[t]||null:("object"==typeof t&&(t=t.id),e.find(function(e){return e.id===t})||null)},be=function(e){if(M(e))return e;if(/:/.test(e)){var t=e.split(":");return t[1]/t[0]}return parseFloat(e)},Pe=function(e){return e.filter(function(e){return!e.archived})},Me={EMPTY:0,IDLE:1,ERROR:2,BUSY:3,READY:4},we=null,Ce=[Ie.LOAD_ERROR,Ie.PROCESSING_ERROR,Ie.PROCESSING_REVERT_ERROR],Ne=[Ie.LOADING,Ie.PROCESSING,Ie.PROCESSING_QUEUED,Ie.INIT],Ge=[Ie.PROCESSING_COMPLETE],Ue=function(e){return Ce.includes(e.status)},Be=function(e){return Ne.includes(e.status)},Fe=function(e){return Ge.includes(e.status)},qe=function(e){return H(e.options.server)&&(H(e.options.server.process)||Y(e.options.server.process))},Ve=function(e){return{GET_STATUS:function(){var t=Pe(e.items),n=Me.EMPTY,r=Me.ERROR,o=Me.BUSY,i=Me.IDLE,a=Me.READY;return 0===t.length?n:t.some(Ue)?r:t.some(Be)?o:t.some(Fe)?a:i},GET_ITEM:function(t){return Le(e.items,t)},GET_ACTIVE_ITEM:function(t){return Le(Pe(e.items),t)},GET_ACTIVE_ITEMS:function(){return Pe(e.items)},GET_ITEMS:function(){return e.items},GET_ITEM_NAME:function(t){var n=Le(e.items,t);return n?n.filename:null},GET_ITEM_SIZE:function(t){var n=Le(e.items,t);return n?n.fileSize:null},GET_STYLES:function(){return Object.keys(e.options).filter(function(e){return/^style/.test(e)}).map(function(t){return{name:t,value:e.options[t]}})},GET_PANEL_ASPECT_RATIO:function(){return/circle/.test(e.options.stylePanelLayout)?1:be(e.options.stylePanelAspectRatio)},GET_ITEM_PANEL_ASPECT_RATIO:function(){return e.options.styleItemPanelAspectRatio},GET_ITEMS_BY_STATUS:function(t){return Pe(e.items).filter(function(e){return e.status===t})},GET_TOTAL_ITEMS:function(){return Pe(e.items).length},SHOULD_UPDATE_FILE_INPUT:function(){return e.options.storeAsFile&&function(){if(null===we)try{var e=new DataTransfer;e.items.add(new File(["hello world"],"This_Works.txt"));var t=document.createElement("input");t.setAttribute("type","file"),t.files=e.files,we=1===t.files.length}catch(e){we=!1}return we}()&&!qe(e)},IS_ASYNC:function(){return qe(e)},GET_FILE_SIZE_LABELS:function(e){return{labelBytes:e("GET_LABEL_FILE_SIZE_BYTES")||void 0,labelKilobytes:e("GET_LABEL_FILE_SIZE_KILOBYTES")||void 0,labelMegabytes:e("GET_LABEL_FILE_SIZE_MEGABYTES")||void 0,labelGigabytes:e("GET_LABEL_FILE_SIZE_GIGABYTES")||void 0}}}},xe=function(e,t,n){return Math.max(Math.min(n,e),t)},Ye=function(e){return/^\s*data:([a-z]+\/[a-z0-9-+.]+(;[a-z-]+=[a-z0-9-]+)?)?(;base64)?,([a-z0-9!$&',()*+;=\-._~:@\/?%\s]*)\s*$/i.test(e)},ke=function(e){return(""+e).split("/").pop().split("?").shift()},je=function(e){return e.split(".").pop()},He=function(e){var t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"";return(t+e).slice(-t.length)},Xe=function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:new Date;return e.getFullYear()+"-"+He(e.getMonth()+1,"00")+"-"+He(e.getDate(),"00")+"_"+He(e.getHours(),"00")+"-"+He(e.getMinutes(),"00")+"-"+He(e.getSeconds(),"00")},We=function(e,t){var n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:null,r=arguments.length>3&&void 0!==arguments[3]?arguments[3]:null,o="string"==typeof n?e.slice(0,e.size,n):e.slice(0,e.size,e.type);return o.lastModifiedDate=new Date,e._relativePath&&(o._relativePath=e._relativePath),U(t)||(t=Xe()),t&&null===r&&je(t)?o.name=t:(r=r||function(e){if("string"!=typeof e)return"";var t=e.split("/").pop();return/svg/.test(t)?"svg":/zip|compressed/.test(t)?"zip":/plain/.test(t)?"txt":/msword/.test(t)?"doc":/[a-z]+/.test(t)?"jpeg"===t?"jpg":t:""}(o.type),o.name=t+(r?"."+r:"")),o},ze=function(e,t){var n=window.BlobBuilder=window.BlobBuilder||window.WebKitBlobBuilder||window.MozBlobBuilder||window.MSBlobBuilder;if(n){var r=new n;return r.append(e),r.getBlob(t)}return new Blob([e],{type:t})},Qe=function(e){return(/^data:(.+);/.exec(e)||[])[1]||null},Ze=function(e){var t=Qe(e);return function(e,t){for(var n=new ArrayBuffer(e.length),r=new Uint8Array(n),o=0;o<e.length;o++)r[o]=e.charCodeAt(o);return ze(n,t)}(function(e){return atob(function(e){return e.split(",")[1].replace(/\s/g,"")}(e))}(e),t)},Ke=function(e){if(!/^content-disposition:/i.test(e))return null;var t=e.split(/filename=|filename\*=.+''/).splice(1).map(function(e){return e.trim().replace(/^["']|[;"']{0,2}$/g,"")}).filter(function(e){return e.length});return t.length?decodeURI(t[t.length-1]):null},$e=function(e){if(/content-length:/i.test(e)){var t=e.match(/[0-9]+/)[0];return t?parseInt(t,10):null}return null},Je=function(e){return/x-content-transfer-id:/i.test(e)&&(e.split(":")[1]||"").trim()||null},et=function(e){var t={source:null,name:null,size:null},n=e.split("\n"),r=!0,o=!1,i=void 0;try{for(var a,s=n[Symbol.iterator]();!(r=(a=s.next()).done);r=!0){var u=a.value,l=Ke(u);if(l)t.name=l;else{var c=$e(u);if(c)t.size=c;else{var f=Je(u);f&&(t.source=f)}}}}catch(e){o=!0,i=e}finally{try{r||null==s.return||s.return()}finally{if(o)throw i}}return t},tt=function(e){var t={source:null,complete:!1,progress:0,size:null,timestamp:null,duration:0,request:null},n=function(n){e?(t.timestamp=Date.now(),t.request=e(n,function(e){t.duration=Date.now()-t.timestamp,t.complete=!0,e instanceof Blob&&(e=We(e,e.name||ke(n))),r.fire("load",e instanceof Blob?e:e?e.body:null)},function(e){r.fire("error","string"==typeof e?{type:"error",code:0,body:e}:e)},function(e,n,o){o&&(t.size=o),t.duration=Date.now()-t.timestamp,e?(t.progress=n/o,r.fire("progress",t.progress)):t.progress=null},function(){r.fire("abort")},function(e){var n=et("string"==typeof e?e:e.headers);r.fire("meta",{size:t.size||n.size,filename:n.name,source:n.source})})):r.fire("error",{type:"error",body:"Can't load URL",code:400})},r=Object.assign({},pe(),{setSource:function(e){return t.source=e},getProgress:function(){return t.progress},abort:function(){t.request&&t.request.abort&&t.request.abort()},load:function(){var e,o,i=t.source;r.fire("init",i),i instanceof File?r.fire("load",i):i instanceof Blob?r.fire("load",We(i,i.name)):Ye(i)?r.fire("load",We(Ze(i),e,null,o)):n(i)}});return r},nt=function(e){return/GET|HEAD/.test(e)},rt=function(e,t,n){var r={onheaders:function(){},onprogress:function(){},onload:function(){},ontimeout:function(){},onerror:function(){},onabort:function(){},abort:function(){o=!0,a.abort()}},o=!1,i=!1;n=Object.assign({method:"POST",headers:{},withCredentials:!1},n),t=encodeURI(t),nt(n.method)&&e&&(t=""+t+encodeURIComponent("string"==typeof e?e:JSON.stringify(e)));var a=new XMLHttpRequest;return(nt(n.method)?a:a.upload).onprogress=function(e){o||r.onprogress(e.lengthComputable,e.loaded,e.total)},a.onreadystatechange=function(){a.readyState<2||4===a.readyState&&0===a.status||i||(i=!0,r.onheaders(a))},a.onload=function(){a.status>=200&&a.status<300?r.onload(a):r.onerror(a)},a.onerror=function(){return r.onerror(a)},a.onabort=function(){o=!0,r.onabort()},a.ontimeout=function(){return r.ontimeout(a)},a.open(n.method,t,!0),V(n.timeout)&&(a.timeout=n.timeout),Object.keys(n.headers).forEach(function(e){var t=unescape(encodeURIComponent(n.headers[e]));a.setRequestHeader(e,t)}),n.responseType&&(a.responseType=n.responseType),n.withCredentials&&(a.withCredentials=!0),a.send(e),r},ot=function(e,t,n,r){return{type:e,code:t,body:n,headers:r}},it=function(e){return function(t){e(ot("error",0,"Timeout",t.getAllResponseHeaders()))}},at=function(e){return/\?/.test(e)},st=function(){for(var e="",t=arguments.length,n=new Array(t),r=0;r<t;r++)n[r]=arguments[r];return n.forEach(function(t){e+=at(e)&&at(t)?t.replace(/\?/,"&"):t}),e},ut=function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"",t=arguments.length>1?arguments[1]:void 0;if("function"==typeof t)return t;if(!t||!U(t.url))return null;var n=t.onload||function(e){return e},r=t.onerror||function(e){return null};return function(o,i,a,s,u,l){var c=rt(o,st(e,t.url),Object.assign({},t,{responseType:"blob"}));return c.onload=function(e){var r=e.getAllResponseHeaders(),a=et(r).name||ke(o);i(ot("load",e.status,"HEAD"===t.method?null:We(n(e.response),a),r))},c.onerror=function(e){a(ot("error",e.status,r(e.response)||e.statusText,e.getAllResponseHeaders()))},c.onheaders=function(e){l(ot("headers",e.status,null,e.getAllResponseHeaders()))},c.ontimeout=it(a),c.onprogress=s,c.onabort=u,c}},lt=0,ct=1,ft=2,dt=3,pt=4,Et=function(e,t,n,r,o,i,a,s,u,l,c){for(var f=[],d=c.chunkTransferId,p=c.chunkServer,E=c.chunkSize,_=c.chunkRetryDelays,T={serverId:d,aborted:!1},I=t.ondata||function(e){return e},v=t.onload||function(e,t){return"HEAD"===t?e.getResponseHeader("Upload-Offset"):e.response},m=t.onerror||function(e){return null},h=Math.floor(r.size/E),g=0;g<=h;g++){var R=g*E,O=r.slice(R,R+E,"application/offset+octet-stream");f[g]={index:g,size:O.size,offset:R,data:O,file:r,progress:0,retries:ue(_),status:lt,error:null,request:null,timeout:null}}var y,D,S,A,L=function(e){return e.status===lt||e.status===dt},b=function(t){if(!T.aborted)if(t=t||f.find(L)){t.status=ft,t.progress=null;var n=p.ondata||function(e){return e},o=p.onerror||function(e){return null},s=st(e,p.url,T.serverId),l="function"==typeof p.headers?p.headers(t):Object.assign({},p.headers,{"Content-Type":"application/offset+octet-stream","Upload-Offset":t.offset,"Upload-Length":r.size,"Upload-Name":r.name}),c=t.request=rt(n(t.data),s,Object.assign({},p,{headers:l}));c.onload=function(){t.status=ct,t.request=null,w()},c.onprogress=function(e,n,r){t.progress=e?n:null,M()},c.onerror=function(e){t.status=dt,t.request=null,t.error=o(e.response)||e.statusText,P(t)||a(ot("error",e.status,o(e.response)||e.statusText,e.getAllResponseHeaders()))},c.ontimeout=function(e){t.status=dt,t.request=null,P(t)||it(a)(e)},c.onabort=function(){t.status=lt,t.request=null,u()}}else f.every(function(e){return e.status===ct})&&i(T.serverId)},P=function(e){return 0!==e.retries.length&&(e.status=pt,clearTimeout(e.timeout),e.timeout=setTimeout(function(){b(e)},e.retries.shift()),!0)},M=function(){var e=f.reduce(function(e,t){return null===e||null===t.progress?null:e+t.progress},0);if(null===e)return s(!1,0,0);var t=f.reduce(function(e,t){return e+t.size},0);s(!0,e,t)},w=function(){f.filter(function(e){return e.status===ft}).length>=1||b()};return T.serverId?(y=function(e){T.aborted||(f.filter(function(t){return t.offset<e}).forEach(function(e){e.status=ct,e.progress=e.size}),w())},D=st(e,p.url,T.serverId),S={headers:"function"==typeof t.headers?t.headers(T.serverId):Object.assign({},t.headers),method:"HEAD"},(A=rt(null,D,S)).onload=function(e){return y(v(e,S.method))},A.onerror=function(e){return a(ot("error",e.status,m(e.response)||e.statusText,e.getAllResponseHeaders()))},A.ontimeout=it(a)):function(i){var s=new FormData;H(o)&&s.append(n,JSON.stringify(o));var u="function"==typeof t.headers?t.headers(r,o):Object.assign({},t.headers,{"Upload-Length":r.size}),l=Object.assign({},t,{headers:u}),c=rt(I(s),st(e,t.url),l);c.onload=function(e){return i(v(e,l.method))},c.onerror=function(e){return a(ot("error",e.status,m(e.response)||e.statusText,e.getAllResponseHeaders()))},c.ontimeout=it(a)}(function(e){T.aborted||(l(e),T.serverId=e,w())}),{abort:function(){T.aborted=!0,f.forEach(function(e){clearTimeout(e.timeout),e.request&&e.request.abort()})}}},_t=function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"",t=arguments.length>1?arguments[1]:void 0,n=arguments.length>2?arguments[2]:void 0,r=arguments.length>3?arguments[3]:void 0;return"function"==typeof t?function(){for(var e=arguments.length,o=new Array(e),i=0;i<e;i++)o[i]=arguments[i];return t.apply(void 0,[n].concat(o,[r]))}:t&&U(t.url)?function(e,t,n,r){return function(o,i,a,s,u,l,c){if(o){var f=r.chunkUploads,d=f&&o.size>r.chunkSize,p=f&&(d||r.chunkForce);if(o instanceof Blob&&p)return Et(e,t,n,o,i,a,s,u,l,c,r);var E=t.ondata||function(e){return e},_=t.onload||function(e){return e},T=t.onerror||function(e){return null},I="function"==typeof t.headers?t.headers(o,i)||{}:Object.assign({},t.headers),v=Object.assign({},t,{headers:I}),m=new FormData;H(i)&&m.append(n,JSON.stringify(i)),(o instanceof Blob?[{name:null,file:o}]:o).forEach(function(e){m.append(n,e.file,null===e.name?e.file.name:""+e.name+e.file.name)});var h=rt(E(m),st(e,t.url),v);return h.onload=function(e){a(ot("load",e.status,_(e.response),e.getAllResponseHeaders()))},h.onerror=function(e){s(ot("error",e.status,T(e.response)||e.statusText,e.getAllResponseHeaders()))},h.ontimeout=it(s),h.onprogress=u,h.onabort=l,h}}}(e,t,n,r):null},Tt=function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"",t=arguments.length>1?arguments[1]:void 0;if("function"==typeof t)return t;if(!t||!U(t.url))return function(e,t){return t()};var n=t.onload||function(e){return e},r=t.onerror||function(e){return null};return function(o,i,a){var s=rt(o,e+t.url,t);return s.onload=function(e){i(ot("load",e.status,n(e.response),e.getAllResponseHeaders()))},s.onerror=function(e){a(ot("error",e.status,r(e.response)||e.statusText,e.getAllResponseHeaders()))},s.ontimeout=it(a),s}},It=function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:0,t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:1;return e+Math.random()*(t-e)},vt=function(e,t){var n={complete:!1,perceivedProgress:0,perceivedPerformanceUpdater:null,progress:null,timestamp:null,perceivedDuration:0,duration:0,request:null,response:null},r=t.allowMinimumUploadDuration,o=function(){n.request&&(n.perceivedPerformanceUpdater.clear(),n.request.abort&&n.request.abort(),n.complete=!0)},i=r?function(){return n.progress?Math.min(n.progress,n.perceivedProgress):null}:function(){return n.progress||null},a=r?function(){return Math.min(n.duration,n.perceivedDuration)}:function(){return n.duration},s=Object.assign({},pe(),{process:function(t,o){var i=function(){0!==n.duration&&null!==n.progress&&s.fire("progress",s.getProgress())},a=function(){n.complete=!0,s.fire("load-perceived",n.response.body)};s.fire("start"),n.timestamp=Date.now(),n.perceivedPerformanceUpdater=function(e){var t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:1e3,n=(arguments.length>2&&void 0!==arguments[2]&&arguments[2],arguments.length>3&&void 0!==arguments[3]?arguments[3]:25),r=arguments.length>4&&void 0!==arguments[4]?arguments[4]:250,o=null,i=Date.now();return t>0&&function a(){var s=Date.now()-i,u=It(n,r);s+u>t&&(u=s+u-t);var l=s/t;l>=1||document.hidden?e(1):(e(l),o=setTimeout(a,u))}(),{clear:function(){clearTimeout(o)}}}(function(e){n.perceivedProgress=e,n.perceivedDuration=Date.now()-n.timestamp,i(),n.response&&1===n.perceivedProgress&&!n.complete&&a()},r?It(750,1500):0),n.request=e(t,o,function(e){n.response=H(e)?e:{type:"load",code:200,body:""+e,headers:{}},n.duration=Date.now()-n.timestamp,n.progress=1,s.fire("load",n.response.body),(!r||r&&1===n.perceivedProgress)&&a()},function(e){n.perceivedPerformanceUpdater.clear(),s.fire("error",H(e)?e:{type:"error",code:0,body:""+e})},function(e,t,r){n.duration=Date.now()-n.timestamp,n.progress=e?t/r:null,i()},function(){n.perceivedPerformanceUpdater.clear(),s.fire("abort",n.response?n.response.body:null)},function(e){s.fire("transfer",e)})},abort:o,getProgress:i,getDuration:a,reset:function(){o(),n.complete=!1,n.perceivedProgress=0,n.progress=0,n.timestamp=null,n.perceivedDuration=0,n.duration=0,n.request=null,n.response=null}});return s},mt=function(e){return e.substring(0,e.lastIndexOf("."))||e},ht=function(e){return!!(e instanceof File||e instanceof Blob&&e.name)},gt=function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:null,t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:null,r=arguments.length>2&&void 0!==arguments[2]?arguments[2]:null,o=oe(),i={archived:!1,frozen:!1,released:!1,source:null,file:r,serverFileReference:t,transferId:null,processingAborted:!1,status:t?Ie.PROCESSING_COMPLETE:Ie.INIT,activeLoader:null,activeProcessor:null},a=null,s={},u=function(e){return i.status=e},l=function(e){if(!i.released&&!i.frozen){for(var t=arguments.length,n=new Array(t>1?t-1:0),r=1;r<t;r++)n[r-1]=arguments[r];f.fire.apply(f,[e].concat(n))}},c=function(e,t,n){var r=e.split("."),o=r[0],i=r.pop(),a=s;r.forEach(function(e){return a=a[e]}),JSON.stringify(a[i])!==JSON.stringify(t)&&(a[i]=t,l("metadata-update",{key:o,value:s[o],silent:n}))},f=Object.assign({id:{get:function(){return o}},origin:{get:function(){return e},set:function(t){return e=t}},serverId:{get:function(){return i.serverFileReference}},transferId:{get:function(){return i.transferId}},status:{get:function(){return i.status}},filename:{get:function(){return i.file.name}},filenameWithoutExtension:{get:function(){return mt(i.file.name)}},fileExtension:{get:function(){return je(i.file.name)}},fileType:{get:function(){return i.file.type}},fileSize:{get:function(){return i.file.size}},file:{get:function(){return i.file}},relativePath:{get:function(){return i.file._relativePath}},source:{get:function(){return i.source}},getMetadata:function(e){return function e(t){if(!H(t))return t;var n=P(t)?[]:{};for(var r in t)if(t.hasOwnProperty(r)){var o=t[r];n[r]=o&&H(o)?e(o):o}return n}(e?s[e]:s)},setMetadata:function(e,t,n){if(H(e)){var r=e;return Object.keys(r).forEach(function(e){c(e,r[e],t)}),e}return c(e,t,n),t},extend:function(e,t){return d[e]=t},abortLoad:function(){i.activeLoader?i.activeLoader.abort():(u(Ie.INIT),l("load-abort"))},retryLoad:function(){i.activeLoader&&i.activeLoader.load()},requestProcessing:function(){i.processingAborted=!1,u(Ie.PROCESSING_QUEUED)},abortProcessing:function(){return new Promise(function(e){if(!i.activeProcessor)return i.processingAborted=!0,u(Ie.IDLE),l("process-abort"),void e();a=function(){e()},i.activeProcessor.abort()})},load:function(t,n,r){i.source=t,f.fireSync("init"),i.file?f.fireSync("load-skip"):(i.file=function(e){var t=[e.name,e.size,e.type];return e instanceof Blob||Ye(e)?t[0]=e.name||Xe():Ye(e)?(t[1]=e.length,t[2]=Qe(e)):U(e)&&(t[0]=ke(e),t[1]=0,t[2]="application/octet-stream"),{name:t[0],size:t[1],type:t[2]}}(t),n.on("init",function(){l("load-init")}),n.on("meta",function(t){i.file.size=t.size,i.file.filename=t.filename,t.source&&(e=ve.LIMBO,i.serverFileReference=t.source,i.status=Ie.PROCESSING_COMPLETE),l("load-meta")}),n.on("progress",function(e){u(Ie.LOADING),l("load-progress",e)}),n.on("error",function(e){u(Ie.LOAD_ERROR),l("load-request-error",e)}),n.on("abort",function(){u(Ie.INIT),l("load-abort")}),n.on("load",function(t){i.activeLoader=null;var n=function(t){i.file=ht(t)?t:i.file,e===ve.LIMBO&&i.serverFileReference?u(Ie.PROCESSING_COMPLETE):u(Ie.IDLE),l("load")};i.serverFileReference?n(t):r(t,n,function(e){i.file=t,l("load-meta"),u(Ie.LOAD_ERROR),l("load-file-error",e)})}),n.setSource(t),i.activeLoader=n,n.load())},process:function e(t,n){if(i.processingAborted)i.processingAborted=!1;else if(u(Ie.PROCESSING),a=null,i.file instanceof Blob){t.on("load",function(e){i.transferId=null,i.serverFileReference=e}),t.on("transfer",function(e){i.transferId=e}),t.on("load-perceived",function(e){i.activeProcessor=null,i.transferId=null,i.serverFileReference=e,u(Ie.PROCESSING_COMPLETE),l("process-complete",e)}),t.on("start",function(){l("process-start")}),t.on("error",function(e){i.activeProcessor=null,u(Ie.PROCESSING_ERROR),l("process-error",e)}),t.on("abort",function(e){i.activeProcessor=null,i.serverFileReference=e,u(Ie.IDLE),l("process-abort"),a&&a()}),t.on("progress",function(e){l("process-progress",e)});var r=console.error;n(i.file,function(e){i.archived||t.process(e,Object.assign({},s))},r),i.activeProcessor=t}else f.on("load",function(){e(t,n)})},revert:function(e,t){return new Promise(function(n,r){var o=null!==i.serverFileReference?i.serverFileReference:i.transferId;null!==o?(e(o,function(){i.serverFileReference=null,i.transferId=null,n()},function(e){t?(u(Ie.PROCESSING_REVERT_ERROR),l("process-revert-error"),r(e)):n()}),u(Ie.IDLE),l("process-revert")):n()})}},pe(),{freeze:function(){return i.frozen=!0},release:function(){return i.released=!0},released:{get:function(){return i.released}},archive:function(){return i.archived=!0},archived:{get:function(){return i.archived}},setFile:function(e){return i.file=e}}),d=n(f);return d},Rt=function(e,t){var n=function(e,t){return M(t)?0:U(t)?e.findIndex(function(e){return e.id===t}):-1}(e,t);if(!(n<0))return e[n]||null},Ot=function(e,t,n,r,o,i){var a=rt(null,e,{method:"GET",responseType:"blob"});return a.onload=function(n){var r=n.getAllResponseHeaders(),o=et(r).name||ke(e);t(ot("load",n.status,We(n.response,o),r))},a.onerror=function(e){n(ot("error",e.status,e.statusText,e.getAllResponseHeaders()))},a.onheaders=function(e){i(ot("headers",e.status,null,e.getAllResponseHeaders()))},a.ontimeout=it(n),a.onprogress=r,a.onabort=o,a},yt=function(e){return 0===e.indexOf("//")&&(e=location.protocol+e),e.toLowerCase().replace("blob:","").replace(/([a-z])?:\/\//,"$1").split("/")[0]},Dt=function(e){return function(){return Y(e)?e.apply(void 0,arguments):e}},St=function(e,t){clearTimeout(t.listUpdateTimeout),t.listUpdateTimeout=setTimeout(function(){e("DID_UPDATE_ITEMS",{items:Pe(t.items)})},0)},At=function(e){for(var t=arguments.length,n=new Array(t>1?t-1:0),r=1;r<t;r++)n[r-1]=arguments[r];return new Promise(function(t){if(!e)return t(!0);var r=e.apply(void 0,n);return null==r?t(!0):"boolean"==typeof r?t(r):void("function"==typeof r.then&&r.then(t))})},Lt=function(e,t){e.items.sort(function(e,n){return t(Te(e),Te(n))})},bt=function(e,t){return function(){var n=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{},r=n.query,o=n.success,i=void 0===o?function(){}:o,a=n.failure,s=void 0===a?function(){}:a,u=se(n,["query","success","failure"]),l=Le(e.items,r);l?t(l,i,s,u||{}):s({error:ot("error",0,"Item not found"),file:null})}},Pt=function(e,t,n){return{ABORT_ALL:function(){Pe(n.items).forEach(function(e){e.freeze(),e.abortLoad(),e.abortProcessing()})},DID_SET_FILES:function(t){var r=t.value,o=(void 0===r?[]:r).map(function(e){return{source:e.source?e.source:e,options:e.options}}),i=Pe(n.items);i.forEach(function(t){o.find(function(e){return e.source===t.source||e.source===t.file})||e("REMOVE_ITEM",{query:t,remove:!1})}),i=Pe(n.items),o.forEach(function(t,n){i.find(function(e){return e.source===t.source||e.file===t.source})||e("ADD_ITEM",Object.assign({},t,{interactionMethod:re,index:n}))})},DID_UPDATE_ITEM_METADATA:function(r){var o=r.id,i=r.action,a=r.change;a.silent||(clearTimeout(n.itemUpdateTimeout),n.itemUpdateTimeout=setTimeout(function(){var r=Rt(n.items,o);if(t("IS_ASYNC")){r.origin===ve.LOCAL&&e("DID_LOAD_ITEM",{id:r.id,error:null,serverFileReference:r.source});var s,u=function(){setTimeout(function(){e("REQUEST_ITEM_PROCESSING",{query:o})},32)};return r.status===Ie.PROCESSING_COMPLETE?(s=n.options.instantUpload,void r.revert(Tt(n.options.server.url,n.options.server.revert),t("GET_FORCE_REVERT")).then(s?u:function(){}).catch(function(){})):r.status===Ie.PROCESSING?function(e){r.abortProcessing().then(e?u:function(){})}(n.options.instantUpload):void(n.options.instantUpload&&u())}Oe("SHOULD_PREPARE_OUTPUT",!1,{item:r,query:t,action:i,change:a}).then(function(n){var i=t("GET_BEFORE_PREPARE_FILE");i&&(n=i(r,n)),n&&e("REQUEST_PREPARE_OUTPUT",{query:o,item:r,success:function(t){e("DID_PREPARE_OUTPUT",{id:o,file:t})}},!0)})},0))},MOVE_ITEM:function(e){var t=e.query,r=e.index,o=Le(n.items,t);if(o){var i=n.items.indexOf(o);i!==(r=xe(r,0,n.items.length-1))&&n.items.splice(r,0,n.items.splice(i,1)[0])}},SORT:function(r){var o=r.compare;Lt(n,o),e("DID_SORT_ITEMS",{items:t("GET_ACTIVE_ITEMS")})},ADD_ITEMS:function(n){var r=n.items,o=n.index,i=n.interactionMethod,a=n.success,s=void 0===a?function(){}:a,u=n.failure,l=void 0===u?function(){}:u,c=o;if(-1===o||void 0===o){var f=t("GET_ITEM_INSERT_LOCATION"),d=t("GET_TOTAL_ITEMS");c="before"===f?0:d}var p=t("GET_IGNORED_FILES"),E=r.filter(function(e){return ht(e)?!p.includes(e.name.toLowerCase()):!M(e)}).map(function(t){return new Promise(function(n,r){e("ADD_ITEM",{interactionMethod:i,source:t.source||t,success:n,failure:r,index:c++,options:t.options||{}})})});Promise.all(E).then(s).catch(l)},ADD_ITEM:function(r){var o=r.source,i=r.index,a=void 0===i?-1:i,s=r.interactionMethod,u=r.success,l=void 0===u?function(){}:u,c=r.failure,f=void 0===c?function(){}:c,d=r.options,p=void 0===d?{}:d;if(M(o))f({error:ot("error",0,"No source"),file:null});else if(!ht(o)||!n.options.ignoredFiles.includes(o.name.toLowerCase())){if(!function(e){var t=Pe(e.items).length;if(!e.options.allowMultiple)return 0===t;var n=e.options.maxFiles;return null===n||t<n}(n)){if(n.options.allowMultiple||!n.options.allowMultiple&&!n.options.allowReplace){var E=ot("warning",0,"Max files");return e("DID_THROW_MAX_FILES",{source:o,error:E}),void f({error:E,file:null})}var _=Pe(n.items)[0];if(_.status===Ie.PROCESSING_COMPLETE||_.status===Ie.PROCESSING_REVERT_ERROR){var T=t("GET_FORCE_REVERT");if(_.revert(Tt(n.options.server.url,n.options.server.revert),T).then(function(){T&&e("ADD_ITEM",{source:o,index:a,interactionMethod:s,success:l,failure:f,options:p})}).catch(function(){}),T)return}e("REMOVE_ITEM",{query:_.id})}var I="local"===p.type?ve.LOCAL:"limbo"===p.type?ve.LIMBO:ve.INPUT,v=gt(I,I===ve.INPUT?null:o,p.file);Object.keys(p.metadata||{}).forEach(function(e){v.setMetadata(e,p.metadata[e])}),ye("DID_CREATE_ITEM",v,{query:t,dispatch:e});var m=t("GET_ITEM_INSERT_LOCATION");n.options.itemInsertLocationFreedom||(a="before"===m?-1:n.items.length),function(e,t,n){M(t)||(void 0===n?e.push(t):function(e,t,n){e.splice(t,0,n)}(e,n=xe(n,0,e.length),t))}(n.items,v,a),Y(m)&&o&&Lt(n,m);var h=v.id;v.on("init",function(){e("DID_INIT_ITEM",{id:h})}),v.on("load-init",function(){e("DID_START_ITEM_LOAD",{id:h})}),v.on("load-meta",function(){e("DID_UPDATE_ITEM_META",{id:h})}),v.on("load-progress",function(t){e("DID_UPDATE_ITEM_LOAD_PROGRESS",{id:h,progress:t})}),v.on("load-request-error",function(t){var r=Dt(n.options.labelFileLoadError)(t);if(t.code>=400&&t.code<500)return e("DID_THROW_ITEM_INVALID",{id:h,error:t,status:{main:r,sub:t.code+" ("+t.body+")"}}),void f({error:t,file:Te(v)});e("DID_THROW_ITEM_LOAD_ERROR",{id:h,error:t,status:{main:r,sub:n.options.labelTapToRetry}})}),v.on("load-file-error",function(t){e("DID_THROW_ITEM_INVALID",{id:h,error:t.status,status:t.status}),f({error:t.status,file:Te(v)})}),v.on("load-abort",function(){e("REMOVE_ITEM",{query:h})}),v.on("load-skip",function(){v.on("metadata-update",function(t){ht(v.file)&&e("DID_UPDATE_ITEM_METADATA",{id:h,change:t})}),e("COMPLETE_LOAD_ITEM",{query:h,item:v,data:{source:o,success:l}})}),v.on("load",function(){var r=function(r){r?(v.on("metadata-update",function(t){e("DID_UPDATE_ITEM_METADATA",{id:h,change:t})}),Oe("SHOULD_PREPARE_OUTPUT",!1,{item:v,query:t}).then(function(r){var i=t("GET_BEFORE_PREPARE_FILE");i&&(r=i(v,r));var a=function(){e("COMPLETE_LOAD_ITEM",{query:h,item:v,data:{source:o,success:l}}),St(e,n)};r?e("REQUEST_PREPARE_OUTPUT",{query:h,item:v,success:function(t){e("DID_PREPARE_OUTPUT",{id:h,file:t}),a()}},!0):a()})):e("REMOVE_ITEM",{query:h})};Oe("DID_LOAD_ITEM",v,{query:t,dispatch:e}).then(function(){At(t("GET_BEFORE_ADD_FILE"),Te(v)).then(r)}).catch(function(t){if(!t||!t.error||!t.status)return r(!1);e("DID_THROW_ITEM_INVALID",{id:h,error:t.error,status:t.status})})}),v.on("process-start",function(){e("DID_START_ITEM_PROCESSING",{id:h})}),v.on("process-progress",function(t){e("DID_UPDATE_ITEM_PROCESS_PROGRESS",{id:h,progress:t})}),v.on("process-error",function(t){e("DID_THROW_ITEM_PROCESSING_ERROR",{id:h,error:t,status:{main:Dt(n.options.labelFileProcessingError)(t),sub:n.options.labelTapToRetry}})}),v.on("process-revert-error",function(t){e("DID_THROW_ITEM_PROCESSING_REVERT_ERROR",{id:h,error:t,status:{main:Dt(n.options.labelFileProcessingRevertError)(t),sub:n.options.labelTapToRetry}})}),v.on("process-complete",function(t){e("DID_COMPLETE_ITEM_PROCESSING",{id:h,error:null,serverFileReference:t}),e("DID_DEFINE_VALUE",{id:h,value:t})}),v.on("process-abort",function(){e("DID_ABORT_ITEM_PROCESSING",{id:h})}),v.on("process-revert",function(){e("DID_REVERT_ITEM_PROCESSING",{id:h}),e("DID_DEFINE_VALUE",{id:h,value:null})}),e("DID_ADD_ITEM",{id:h,index:a,interactionMethod:s}),St(e,n);var g=n.options.server||{},R=g.url,O=g.load,y=g.restore,D=g.fetch;v.load(o,tt(I===ve.INPUT?U(o)&&function(e){return(e.indexOf(":")>-1||e.indexOf("//")>-1)&&yt(location.href)!==yt(e)}(o)&&D?ut(R,D):Ot:ut(R,I===ve.LIMBO?y:O)),function(e,n,r){Oe("LOAD_FILE",e,{query:t}).then(n).catch(r)})}},REQUEST_PREPARE_OUTPUT:function(e){var n=e.item,r=e.success,o=e.failure,i=void 0===o?function(){}:o,a={error:ot("error",0,"Item not found"),file:null};if(n.archived)return i(a);Oe("PREPARE_OUTPUT",n.file,{query:t,item:n}).then(function(e){Oe("COMPLETE_PREPARE_OUTPUT",e,{query:t,item:n}).then(function(e){if(n.archived)return i(a);r(e)})})},COMPLETE_LOAD_ITEM:function(r){var o=r.item,i=r.data,a=i.success,s=i.source,u=t("GET_ITEM_INSERT_LOCATION");if(Y(u)&&s&&Lt(n,u),e("DID_LOAD_ITEM",{id:o.id,error:null,serverFileReference:o.origin===ve.INPUT?null:s}),a(Te(o)),o.origin!==ve.LOCAL)return o.origin===ve.LIMBO?(e("DID_COMPLETE_ITEM_PROCESSING",{id:o.id,error:null,serverFileReference:s}),void e("DID_DEFINE_VALUE",{id:o.id,value:o.serverId||s})):void(t("IS_ASYNC")&&n.options.instantUpload&&e("REQUEST_ITEM_PROCESSING",{query:o.id}));e("DID_LOAD_LOCAL_ITEM",{id:o.id})},RETRY_ITEM_LOAD:bt(n,function(e){e.retryLoad()}),REQUEST_ITEM_PREPARE:bt(n,function(t,n,r){e("REQUEST_PREPARE_OUTPUT",{query:t.id,item:t,success:function(r){e("DID_PREPARE_OUTPUT",{id:t.id,file:r}),n({file:t,output:r})},failure:r},!0)}),REQUEST_ITEM_PROCESSING:bt(n,function(r,o,i){if(r.status===Ie.IDLE||r.status===Ie.PROCESSING_ERROR)r.status!==Ie.PROCESSING_QUEUED&&(r.requestProcessing(),e("DID_REQUEST_ITEM_PROCESSING",{id:r.id}),e("PROCESS_ITEM",{query:r,success:o,failure:i},!0));else{var a=function(){return e("REQUEST_ITEM_PROCESSING",{query:r,success:o,failure:i})},s=function(){return document.hidden?a():setTimeout(a,32)};r.status===Ie.PROCESSING_COMPLETE||r.status===Ie.PROCESSING_REVERT_ERROR?r.revert(Tt(n.options.server.url,n.options.server.revert),t("GET_FORCE_REVERT")).then(s).catch(function(){}):r.status===Ie.PROCESSING&&r.abortProcessing().then(s)}}),PROCESS_ITEM:bt(n,function(r,o,i){var a=t("GET_MAX_PARALLEL_UPLOADS");if(t("GET_ITEMS_BY_STATUS",Ie.PROCESSING).length!==a){if(r.status!==Ie.PROCESSING){var s=function t(){var r=n.processingQueue.shift();if(r){var o=r.id,i=r.success,a=r.failure,s=Le(n.items,o);s&&!s.archived?e("PROCESS_ITEM",{query:o,success:i,failure:a},!0):t()}};r.onOnce("process-complete",function(){o(Te(r)),s();var i=n.options.server;if(n.options.instantUpload&&r.origin===ve.LOCAL&&Y(i.remove)){var a=function(){};r.origin=ve.LIMBO,n.options.server.remove(r.source,a,a)}t("GET_ITEMS_BY_STATUS",Ie.PROCESSING_COMPLETE).length===n.items.length&&e("DID_COMPLETE_ITEM_PROCESSING_ALL")}),r.onOnce("process-error",function(e){i({error:e,file:Te(r)}),s()});var u=n.options;r.process(vt(_t(u.server.url,u.server.process,u.name,{chunkTransferId:r.transferId,chunkServer:u.server.patch,chunkUploads:u.chunkUploads,chunkForce:u.chunkForce,chunkSize:u.chunkSize,chunkRetryDelays:u.chunkRetryDelays}),{allowMinimumUploadDuration:t("GET_ALLOW_MINIMUM_UPLOAD_DURATION")}),function(n,o,i){Oe("PREPARE_OUTPUT",n,{query:t,item:r}).then(function(t){e("DID_PREPARE_OUTPUT",{id:r.id,file:t}),o(t)}).catch(i)})}}else n.processingQueue.push({id:r.id,success:o,failure:i})}),RETRY_ITEM_PROCESSING:bt(n,function(t){e("REQUEST_ITEM_PROCESSING",{query:t})}),REQUEST_REMOVE_ITEM:bt(n,function(n){At(t("GET_BEFORE_REMOVE_FILE"),Te(n)).then(function(t){t&&e("REMOVE_ITEM",{query:n})})}),RELEASE_ITEM:bt(n,function(e){e.release()}),REMOVE_ITEM:bt(n,function(r,o,i,a){var s=function(){var t=r.id;Rt(n.items,t).archive(),e("DID_REMOVE_ITEM",{error:null,id:t,item:r}),St(e,n),o(Te(r))},u=n.options.server;r.origin===ve.LOCAL&&u&&Y(u.remove)&&!1!==a.remove?(e("DID_START_ITEM_REMOVE",{id:r.id}),u.remove(r.source,function(){return s()},function(t){e("DID_THROW_ITEM_REMOVE_ERROR",{id:r.id,error:ot("error",0,t,null),status:{main:Dt(n.options.labelFileRemoveError)(t),sub:n.options.labelTapToRetry}})})):((a.revert&&r.origin!==ve.LOCAL&&null!==r.serverId||n.options.chunkUploads&&r.file.size>n.options.chunkSize||n.options.chunkUploads&&n.options.chunkForce)&&r.revert(Tt(n.options.server.url,n.options.server.revert),t("GET_FORCE_REVERT")),s())}),ABORT_ITEM_LOAD:bt(n,function(e){e.abortLoad()}),ABORT_ITEM_PROCESSING:bt(n,function(t){t.serverId?e("REVERT_ITEM_PROCESSING",{id:t.id}):t.abortProcessing().then(function(){n.options.instantUpload&&e("REMOVE_ITEM",{query:t.id})})}),REQUEST_REVERT_ITEM_PROCESSING:bt(n,function(r){if(n.options.instantUpload){var o=function(t){t&&e("REVERT_ITEM_PROCESSING",{query:r})},i=t("GET_BEFORE_REMOVE_FILE");if(!i)return o(!0);var a=i(Te(r));return null==a?o(!0):"boolean"==typeof a?o(a):void("function"==typeof a.then&&a.then(o))}e("REVERT_ITEM_PROCESSING",{query:r})}),REVERT_ITEM_PROCESSING:bt(n,function(r){r.revert(Tt(n.options.server.url,n.options.server.revert),t("GET_FORCE_REVERT")).then(function(){(n.options.instantUpload||function(e){return!ht(e.file)}(r))&&e("REMOVE_ITEM",{query:r.id})}).catch(function(){})}),SET_OPTIONS:function(t){var n=t.options,r=Object.keys(n),o=Mt.filter(function(e){return r.includes(e)});[].concat(ue(o),ue(Object.keys(n).filter(function(e){return!o.includes(e)}))).forEach(function(t){e("SET_"+Z(t,"_").toUpperCase(),{value:n[t]})})}}},Mt=["server"],wt=function(e){return e},Ct=function(e){return document.createElement(e)},Nt=function(e,t){var n=e.childNodes[0];n?t!==n.nodeValue&&(n.nodeValue=t):(n=document.createTextNode(t),e.appendChild(n))},Gt=function(e,t,n,r){var o=(r%360-90)*Math.PI/180;return{x:e+n*Math.cos(o),y:t+n*Math.sin(o)}},Ut=function(e,t,n,r,o){var i=1;return o>r&&o-r<=.5&&(i=0),r>o&&r-o>=.5&&(i=0),function(e,t,n,r,o,i){var a=Gt(e,t,n,o),s=Gt(e,t,n,r);return["M",a.x,a.y,"A",n,n,0,i,0,s.x,s.y].join(" ")}(e,t,n,360*Math.min(.9999,r),360*Math.min(.9999,o),i)},Bt=S({tag:"div",name:"progress-indicator",ignoreRectUpdate:!0,ignoreRect:!0,create:function(e){var t=e.root,n=e.props;n.spin=!1,n.progress=0,n.opacity=0;var r=a("svg");t.ref.path=a("path",{"stroke-width":2,"stroke-linecap":"round"}),r.appendChild(t.ref.path),t.ref.svg=r,t.appendChild(r)},write:function(e){var t=e.root,n=e.props;if(0!==n.opacity){n.align&&(t.element.dataset.align=n.align);var o=parseInt(r(t.ref.path,"stroke-width"),10),i=.5*t.rect.element.width,a=0,s=0;n.spin?(a=0,s=.5):(a=0,s=n.progress);var u=Ut(i,i,i-o,a,s);r(t.ref.path,"d",u),r(t.ref.path,"stroke-opacity",n.spin||n.progress>0?1:0)}},mixins:{apis:["progress","spin","align"],styles:["opacity"],animations:{opacity:{type:"tween",duration:500},progress:{type:"spring",stiffness:.95,damping:.65,mass:10}}}}),Ft=S({tag:"button",attributes:{type:"button"},ignoreRect:!0,ignoreRectUpdate:!0,name:"file-action-button",mixins:{apis:["label"],styles:["translateX","translateY","scaleX","scaleY","opacity"],animations:{scaleX:"spring",scaleY:"spring",translateX:"spring",translateY:"spring",opacity:{type:"tween",duration:250}},listeners:!0},create:function(e){var t=e.root,n=e.props;t.element.innerHTML=(n.icon||"")+"<span>"+n.label+"</span>",n.isDisabled=!1},write:function(e){var t=e.root,n=e.props,o=n.isDisabled,i=t.query("GET_DISABLED")||0===n.opacity;i&&!o?(n.isDisabled=!0,r(t.element,"disabled","disabled")):!i&&o&&(n.isDisabled=!1,t.element.removeAttribute("disabled"))}}),qt=function(e){var t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:".",n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:1e3,r=arguments.length>3&&void 0!==arguments[3]?arguments[3]:{},o=r.labelBytes,i=void 0===o?"bytes":o,a=r.labelKilobytes,s=void 0===a?"KB":a,u=r.labelMegabytes,l=void 0===u?"MB":u,c=r.labelGigabytes,f=void 0===c?"GB":c,d=n,p=n*n,E=n*n*n;return(e=Math.round(Math.abs(e)))<d?e+" "+i:e<p?Math.floor(e/d)+" "+s:e<E?Vt(e/p,1,t)+" "+l:Vt(e/E,2,t)+" "+f},Vt=function(e,t,n){return e.toFixed(t).split(".").filter(function(e){return"0"!==e}).join(n)},xt=function(e){var t=e.root,n=e.props;Nt(t.ref.fileSize,qt(t.query("GET_ITEM_SIZE",n.id),".",t.query("GET_FILE_SIZE_BASE"),t.query("GET_FILE_SIZE_LABELS",t.query))),Nt(t.ref.fileName,wt(t.query("GET_ITEM_NAME",n.id)))},Yt=function(e){var t=e.root,n=e.props;V(t.query("GET_ITEM_SIZE",n.id))?xt({root:t,props:n}):Nt(t.ref.fileSize,t.query("GET_LABEL_FILE_SIZE_NOT_AVAILABLE"))},kt=S({name:"file-info",ignoreRect:!0,ignoreRectUpdate:!0,write:A({DID_LOAD_ITEM:xt,DID_UPDATE_ITEM_META:xt,DID_THROW_ITEM_LOAD_ERROR:Yt,DID_THROW_ITEM_INVALID:Yt}),didCreateView:function(e){ye("CREATE_VIEW",Object.assign({},e,{view:e}))},create:function(e){var t=e.root,n=e.props,o=Ct("span");o.className="filepond--file-info-main",r(o,"aria-hidden","true"),t.appendChild(o),t.ref.fileName=o;var i=Ct("span");i.className="filepond--file-info-sub",t.appendChild(i),t.ref.fileSize=i,Nt(i,t.query("GET_LABEL_FILE_WAITING_FOR_SIZE")),Nt(o,wt(t.query("GET_ITEM_NAME",n.id)))},mixins:{styles:["translateX","translateY"],animations:{translateX:"spring",translateY:"spring"}}}),jt=function(e){return Math.round(100*e)},Ht=function(e){var t=e.root,n=e.action,r=null===n.progress?t.query("GET_LABEL_FILE_LOADING"):t.query("GET_LABEL_FILE_LOADING")+" "+jt(n.progress)+"%";Nt(t.ref.main,r),Nt(t.ref.sub,t.query("GET_LABEL_TAP_TO_CANCEL"))},Xt=function(e){var t=e.root;Nt(t.ref.main,""),Nt(t.ref.sub,"")},Wt=function(e){var t=e.root,n=e.action;Nt(t.ref.main,n.status.main),Nt(t.ref.sub,n.status.sub)},zt=S({name:"file-status",ignoreRect:!0,ignoreRectUpdate:!0,write:A({DID_LOAD_ITEM:Xt,DID_REVERT_ITEM_PROCESSING:Xt,DID_REQUEST_ITEM_PROCESSING:function(e){var t=e.root;Nt(t.ref.main,t.query("GET_LABEL_FILE_PROCESSING")),Nt(t.ref.sub,t.query("GET_LABEL_TAP_TO_CANCEL"))},DID_ABORT_ITEM_PROCESSING:function(e){var t=e.root;Nt(t.ref.main,t.query("GET_LABEL_FILE_PROCESSING_ABORTED")),Nt(t.ref.sub,t.query("GET_LABEL_TAP_TO_RETRY"))},DID_COMPLETE_ITEM_PROCESSING:function(e){var t=e.root;Nt(t.ref.main,t.query("GET_LABEL_FILE_PROCESSING_COMPLETE")),Nt(t.ref.sub,t.query("GET_LABEL_TAP_TO_UNDO"))},DID_UPDATE_ITEM_PROCESS_PROGRESS:function(e){var t=e.root,n=e.action,r=null===n.progress?t.query("GET_LABEL_FILE_PROCESSING"):t.query("GET_LABEL_FILE_PROCESSING")+" "+jt(n.progress)+"%";Nt(t.ref.main,r),Nt(t.ref.sub,t.query("GET_LABEL_TAP_TO_CANCEL"))},DID_UPDATE_ITEM_LOAD_PROGRESS:Ht,DID_THROW_ITEM_LOAD_ERROR:Wt,DID_THROW_ITEM_INVALID:Wt,DID_THROW_ITEM_PROCESSING_ERROR:Wt,DID_THROW_ITEM_PROCESSING_REVERT_ERROR:Wt,DID_THROW_ITEM_REMOVE_ERROR:Wt}),didCreateView:function(e){ye("CREATE_VIEW",Object.assign({},e,{view:e}))},create:function(e){var t=e.root,n=Ct("span");n.className="filepond--file-status-main",t.appendChild(n),t.ref.main=n;var r=Ct("span");r.className="filepond--file-status-sub",t.appendChild(r),t.ref.sub=r,Ht({root:t,action:{progress:null}})},mixins:{styles:["translateX","translateY","opacity"],animations:{opacity:{type:"tween",duration:250},translateX:"spring",translateY:"spring"}}}),Qt={AbortItemLoad:{label:"GET_LABEL_BUTTON_ABORT_ITEM_LOAD",action:"ABORT_ITEM_LOAD",className:"filepond--action-abort-item-load",align:"LOAD_INDICATOR_POSITION"},RetryItemLoad:{label:"GET_LABEL_BUTTON_RETRY_ITEM_LOAD",action:"RETRY_ITEM_LOAD",icon:"GET_ICON_RETRY",className:"filepond--action-retry-item-load",align:"BUTTON_PROCESS_ITEM_POSITION"},RemoveItem:{label:"GET_LABEL_BUTTON_REMOVE_ITEM",action:"REQUEST_REMOVE_ITEM",icon:"GET_ICON_REMOVE",className:"filepond--action-remove-item",align:"BUTTON_REMOVE_ITEM_POSITION"},ProcessItem:{label:"GET_LABEL_BUTTON_PROCESS_ITEM",action:"REQUEST_ITEM_PROCESSING",icon:"GET_ICON_PROCESS",className:"filepond--action-process-item",align:"BUTTON_PROCESS_ITEM_POSITION"},AbortItemProcessing:{label:"GET_LABEL_BUTTON_ABORT_ITEM_PROCESSING",action:"ABORT_ITEM_PROCESSING",className:"filepond--action-abort-item-processing",align:"BUTTON_PROCESS_ITEM_POSITION"},RetryItemProcessing:{label:"GET_LABEL_BUTTON_RETRY_ITEM_PROCESSING",action:"RETRY_ITEM_PROCESSING",icon:"GET_ICON_RETRY",className:"filepond--action-retry-item-processing",align:"BUTTON_PROCESS_ITEM_POSITION"},RevertItemProcessing:{label:"GET_LABEL_BUTTON_UNDO_ITEM_PROCESSING",action:"REQUEST_REVERT_ITEM_PROCESSING",icon:"GET_ICON_UNDO",className:"filepond--action-revert-item-processing",align:"BUTTON_PROCESS_ITEM_POSITION"}},Zt=[];t(Qt,function(e){Zt.push(e)});var Kt,$t=function(e){if("right"===nn(e))return 0;var t=e.ref.buttonRemoveItem.rect.element;return t.hidden?null:t.width+t.left},Jt=function(e){return e.ref.buttonAbortItemLoad.rect.element.width},en=function(e){return Math.floor(e.ref.buttonRemoveItem.rect.element.height/4)},tn=function(e){return Math.floor(e.ref.buttonRemoveItem.rect.element.left/2)},nn=function(e){return e.query("GET_STYLE_BUTTON_REMOVE_ITEM_POSITION")},rn={buttonAbortItemLoad:{opacity:0},buttonRetryItemLoad:{opacity:0},buttonRemoveItem:{opacity:0},buttonProcessItem:{opacity:0},buttonAbortItemProcessing:{opacity:0},buttonRetryItemProcessing:{opacity:0},buttonRevertItemProcessing:{opacity:0},loadProgressIndicator:{opacity:0,align:function(e){return e.query("GET_STYLE_LOAD_INDICATOR_POSITION")}},processProgressIndicator:{opacity:0,align:function(e){return e.query("GET_STYLE_PROGRESS_INDICATOR_POSITION")}},processingCompleteIndicator:{opacity:0,scaleX:.75,scaleY:.75},info:{translateX:0,translateY:0,opacity:0},status:{translateX:0,translateY:0,opacity:0}},on={buttonRemoveItem:{opacity:1},buttonProcessItem:{opacity:1},info:{translateX:$t},status:{translateX:$t}},an={buttonAbortItemProcessing:{opacity:1},processProgressIndicator:{opacity:1},status:{opacity:1}},sn={DID_THROW_ITEM_INVALID:{buttonRemoveItem:{opacity:1},info:{translateX:$t},status:{translateX:$t,opacity:1}},DID_START_ITEM_LOAD:{buttonAbortItemLoad:{opacity:1},loadProgressIndicator:{opacity:1},status:{opacity:1}},DID_THROW_ITEM_LOAD_ERROR:{buttonRetryItemLoad:{opacity:1},buttonRemoveItem:{opacity:1},info:{translateX:$t},status:{opacity:1}},DID_START_ITEM_REMOVE:{processProgressIndicator:{opacity:1,align:nn},info:{translateX:$t},status:{opacity:0}},DID_THROW_ITEM_REMOVE_ERROR:{processProgressIndicator:{opacity:0,align:nn},buttonRemoveItem:{opacity:1},info:{translateX:$t},status:{opacity:1,translateX:$t}},DID_LOAD_ITEM:on,DID_LOAD_LOCAL_ITEM:{buttonRemoveItem:{opacity:1},info:{translateX:$t},status:{translateX:$t}},DID_START_ITEM_PROCESSING:an,DID_REQUEST_ITEM_PROCESSING:an,DID_UPDATE_ITEM_PROCESS_PROGRESS:an,DID_COMPLETE_ITEM_PROCESSING:{buttonRevertItemProcessing:{opacity:1},info:{opacity:1},status:{opacity:1}},DID_THROW_ITEM_PROCESSING_ERROR:{buttonRemoveItem:{opacity:1},buttonRetryItemProcessing:{opacity:1},status:{opacity:1},info:{translateX:$t}},DID_THROW_ITEM_PROCESSING_REVERT_ERROR:{buttonRevertItemProcessing:{opacity:1},status:{opacity:1},info:{opacity:1}},DID_ABORT_ITEM_PROCESSING:{buttonRemoveItem:{opacity:1},buttonProcessItem:{opacity:1},info:{translateX:$t},status:{opacity:1}},DID_REVERT_ITEM_PROCESSING:on},un=S({create:function(e){var t=e.root;t.element.innerHTML=t.query("GET_ICON_DONE")},name:"processing-complete-indicator",ignoreRect:!0,mixins:{styles:["scaleX","scaleY","opacity"],animations:{scaleX:"spring",scaleY:"spring",opacity:{type:"tween",duration:250}}}}),ln=A({DID_SET_LABEL_BUTTON_ABORT_ITEM_PROCESSING:function(e){var t=e.root,n=e.action;t.ref.buttonAbortItemProcessing.label=n.value},DID_SET_LABEL_BUTTON_ABORT_ITEM_LOAD:function(e){var t=e.root,n=e.action;t.ref.buttonAbortItemLoad.label=n.value},DID_SET_LABEL_BUTTON_ABORT_ITEM_REMOVAL:function(e){var t=e.root,n=e.action;t.ref.buttonAbortItemRemoval.label=n.value},DID_REQUEST_ITEM_PROCESSING:function(e){var t=e.root;t.ref.processProgressIndicator.spin=!0,t.ref.processProgressIndicator.progress=0},DID_START_ITEM_LOAD:function(e){var t=e.root;t.ref.loadProgressIndicator.spin=!0,t.ref.loadProgressIndicator.progress=0},DID_START_ITEM_REMOVE:function(e){var t=e.root;t.ref.processProgressIndicator.spin=!0,t.ref.processProgressIndicator.progress=0},DID_UPDATE_ITEM_LOAD_PROGRESS:function(e){var t=e.root,n=e.action;t.ref.loadProgressIndicator.spin=!1,t.ref.loadProgressIndicator.progress=n.progress},DID_UPDATE_ITEM_PROCESS_PROGRESS:function(e){var t=e.root,n=e.action;t.ref.processProgressIndicator.spin=!1,t.ref.processProgressIndicator.progress=n.progress}}),cn=S({create:function(e){var n,r=e.root,o=e.props,i=Object.keys(Qt).reduce(function(e,t){return e[t]=Object.assign({},Qt[t]),e},{}),a=o.id,s=r.query("GET_ALLOW_REVERT"),u=r.query("GET_ALLOW_REMOVE"),l=r.query("GET_ALLOW_PROCESS"),c=r.query("GET_INSTANT_UPLOAD"),f=r.query("IS_ASYNC"),d=r.query("GET_STYLE_BUTTON_REMOVE_ITEM_ALIGN");f?l&&!s?n=function(e){return!/RevertItemProcessing/.test(e)}:!l&&s?n=function(e){return!/ProcessItem|RetryItemProcessing|AbortItemProcessing/.test(e)}:l||s||(n=function(e){return!/Process/.test(e)}):n=function(e){return!/Process/.test(e)};var p=n?Zt.filter(n):Zt.concat();if(c&&s&&(i.RevertItemProcessing.label="GET_LABEL_BUTTON_REMOVE_ITEM",i.RevertItemProcessing.icon="GET_ICON_REMOVE"),f&&!s){var E=sn.DID_COMPLETE_ITEM_PROCESSING;E.info.translateX=tn,E.info.translateY=en,E.status.translateY=en,E.processingCompleteIndicator={opacity:1,scaleX:1,scaleY:1}}if(f&&!l&&(["DID_START_ITEM_PROCESSING","DID_REQUEST_ITEM_PROCESSING","DID_UPDATE_ITEM_PROCESS_PROGRESS","DID_THROW_ITEM_PROCESSING_ERROR"].forEach(function(e){sn[e].status.translateY=en}),sn.DID_THROW_ITEM_PROCESSING_ERROR.status.translateX=Jt),d&&s){i.RevertItemProcessing.align="BUTTON_REMOVE_ITEM_POSITION";var _=sn.DID_COMPLETE_ITEM_PROCESSING;_.info.translateX=$t,_.status.translateY=en,_.processingCompleteIndicator={opacity:1,scaleX:1,scaleY:1}}u||(i.RemoveItem.disabled=!0),t(i,function(e,t){var n=r.createChildView(Ft,{label:r.query(t.label),icon:r.query(t.icon),opacity:0});p.includes(e)&&r.appendChildView(n),t.disabled&&(n.element.setAttribute("disabled","disabled"),n.element.setAttribute("hidden","hidden")),n.element.dataset.align=r.query("GET_STYLE_"+t.align),n.element.classList.add(t.className),n.on("click",function(e){e.stopPropagation(),t.disabled||r.dispatch(t.action,{query:a})}),r.ref["button"+e]=n}),r.ref.processingCompleteIndicator=r.appendChildView(r.createChildView(un)),r.ref.processingCompleteIndicator.element.dataset.align=r.query("GET_STYLE_BUTTON_PROCESS_ITEM_POSITION"),r.ref.info=r.appendChildView(r.createChildView(kt,{id:a})),r.ref.status=r.appendChildView(r.createChildView(zt,{id:a}));var T=r.appendChildView(r.createChildView(Bt,{opacity:0,align:r.query("GET_STYLE_LOAD_INDICATOR_POSITION")}));T.element.classList.add("filepond--load-indicator"),r.ref.loadProgressIndicator=T;var I=r.appendChildView(r.createChildView(Bt,{opacity:0,align:r.query("GET_STYLE_PROGRESS_INDICATOR_POSITION")}));I.element.classList.add("filepond--process-indicator"),r.ref.processProgressIndicator=I,r.ref.activeStyles=[]},write:function(e){var n=e.root,r=e.actions,o=e.props;ln({root:n,actions:r,props:o});var i=r.concat().filter(function(e){return/^DID_/.test(e.type)}).reverse().find(function(e){return sn[e.type]});if(i){n.ref.activeStyles=[];var a=sn[i.type];t(rn,function(e,r){var o=n.ref[e];t(r,function(t,r){var i=a[e]&&void 0!==a[e][t]?a[e][t]:r;n.ref.activeStyles.push({control:o,key:t,value:i})})})}n.ref.activeStyles.forEach(function(e){var t=e.control,r=e.key,o=e.value;t[r]="function"==typeof o?o(n):o})},didCreateView:function(e){ye("CREATE_VIEW",Object.assign({},e,{view:e}))},name:"file"}),fn=S({create:function(e){var t=e.root,n=e.props;t.ref.fileName=Ct("legend"),t.appendChild(t.ref.fileName),t.ref.file=t.appendChildView(t.createChildView(cn,{id:n.id})),t.ref.data=!1},ignoreRect:!0,write:A({DID_LOAD_ITEM:function(e){var t=e.root,n=e.props;Nt(t.ref.fileName,wt(t.query("GET_ITEM_NAME",n.id)))}}),didCreateView:function(e){ye("CREATE_VIEW",Object.assign({},e,{view:e}))},tag:"fieldset",name:"file-wrapper"}),dn={type:"spring",damping:.6,mass:7},pn=function(e,t,n){var r=S({name:"panel-"+t.name+" filepond--"+n,mixins:t.mixins,ignoreRectUpdate:!0}),o=e.createChildView(r,t.props);e.ref[t.name]=e.appendChildView(o)},En=S({name:"panel",read:function(e){var t=e.root;return e.props.heightCurrent=t.ref.bottom.translateY},write:function(e){var t=e.root,n=e.props;if(null!==t.ref.scalable&&n.scalable===t.ref.scalable||(t.ref.scalable=!N(n.scalable)||n.scalable,t.element.dataset.scalable=t.ref.scalable),n.height){var r=t.ref.top.rect.element,o=t.ref.bottom.rect.element,i=Math.max(r.height+o.height,n.height);t.ref.center.translateY=r.height,t.ref.center.scaleY=(i-r.height-o.height)/100,t.ref.bottom.translateY=i-o.height}},create:function(e){var t=e.root,n=e.props;[{name:"top"},{name:"center",props:{translateY:null,scaleY:null},mixins:{animations:{scaleY:dn},styles:["translateY","scaleY"]}},{name:"bottom",props:{translateY:null},mixins:{animations:{translateY:dn},styles:["translateY"]}}].forEach(function(e){pn(t,e,n.name)}),t.element.classList.add("filepond--"+n.name),t.ref.scalable=null},ignoreRect:!0,mixins:{apis:["height","heightCurrent","scalable"]}}),_n={type:"spring",stiffness:.75,damping:.45,mass:10},Tn={DID_START_ITEM_LOAD:"busy",DID_UPDATE_ITEM_LOAD_PROGRESS:"loading",DID_THROW_ITEM_INVALID:"load-invalid",DID_THROW_ITEM_LOAD_ERROR:"load-error",DID_LOAD_ITEM:"idle",DID_THROW_ITEM_REMOVE_ERROR:"remove-error",DID_START_ITEM_REMOVE:"busy",DID_START_ITEM_PROCESSING:"busy processing",DID_REQUEST_ITEM_PROCESSING:"busy processing",DID_UPDATE_ITEM_PROCESS_PROGRESS:"processing",DID_COMPLETE_ITEM_PROCESSING:"processing-complete",DID_THROW_ITEM_PROCESSING_ERROR:"processing-error",DID_THROW_ITEM_PROCESSING_REVERT_ERROR:"processing-revert-error",DID_ABORT_ITEM_PROCESSING:"cancelled",DID_REVERT_ITEM_PROCESSING:"idle"},In=A({DID_UPDATE_PANEL_HEIGHT:function(e){var t=e.root,n=e.action;t.height=n.height}}),vn=A({DID_GRAB_ITEM:function(e){var t=e.root;e.props.dragOrigin={x:t.translateX,y:t.translateY}},DID_DRAG_ITEM:function(e){e.root.element.dataset.dragState="drag"},DID_DROP_ITEM:function(e){var t=e.root,n=e.props;n.dragOffset=null,n.dragOrigin=null,t.element.dataset.dragState="drop"}},function(e){var t=e.root,n=e.actions,r=e.props,o=e.shouldOptimize;"drop"===t.element.dataset.dragState&&t.scaleX<=1&&(t.element.dataset.dragState="idle");var i=n.concat().filter(function(e){return/^DID_/.test(e.type)}).reverse().find(function(e){return Tn[e.type]});i&&i.type!==r.currentState&&(r.currentState=i.type,t.element.dataset.filepondItemState=Tn[r.currentState]||"");var a=t.query("GET_ITEM_PANEL_ASPECT_RATIO")||t.query("GET_PANEL_ASPECT_RATIO");a?o||(t.height=t.rect.element.width*a):(In({root:t,actions:n,props:r}),!t.height&&t.ref.container.rect.element.height>0&&(t.height=t.ref.container.rect.element.height)),o&&(t.ref.panel.height=null),t.ref.panel.height=t.height}),mn=S({create:function(e){var t=e.root,n=e.props;t.ref.handleClick=function(e){return t.dispatch("DID_ACTIVATE_ITEM",{id:n.id})},t.element.id="filepond--item-"+n.id,t.element.addEventListener("click",t.ref.handleClick),t.ref.container=t.appendChildView(t.createChildView(fn,{id:n.id})),t.ref.panel=t.appendChildView(t.createChildView(En,{name:"item-panel"})),t.ref.panel.height=null,n.markedForRemoval=!1,t.query("GET_ALLOW_REORDER")&&(t.element.dataset.dragState="idle",t.element.addEventListener("pointerdown",function(e){if(e.isPrimary){var r=!1,o=e.pageX,i=e.pageY;n.dragOrigin={x:t.translateX,y:t.translateY},n.dragCenter={x:e.offsetX,y:e.offsetY};var a,s,u,l=(a=t.query("GET_ACTIVE_ITEMS"),s=a.map(function(e){return e.id}),u=void 0,{setIndex:function(e){u=e},getIndex:function(){return u},getItemIndex:function(e){return s.indexOf(e.id)}});t.dispatch("DID_GRAB_ITEM",{id:n.id,dragState:l});var c=function(e){e.isPrimary&&(e.stopPropagation(),e.preventDefault(),n.dragOffset={x:e.pageX-o,y:e.pageY-i},n.dragOffset.x*n.dragOffset.x+n.dragOffset.y*n.dragOffset.y>16&&!r&&(r=!0,t.element.removeEventListener("click",t.ref.handleClick)),t.dispatch("DID_DRAG_ITEM",{id:n.id,dragState:l}))},f=function(e){e.isPrimary&&(n.dragOffset={x:e.pageX-o,y:e.pageY-i},p())},d=function(){p()},p=function(){document.removeEventListener("pointercancel",d),document.removeEventListener("pointermove",c),document.removeEventListener("pointerup",f),t.dispatch("DID_DROP_ITEM",{id:n.id,dragState:l}),r&&setTimeout(function(){return t.element.addEventListener("click",t.ref.handleClick)},0)};document.addEventListener("pointercancel",d),document.addEventListener("pointermove",c),document.addEventListener("pointerup",f)}}))},write:vn,destroy:function(e){var t=e.root,n=e.props;t.element.removeEventListener("click",t.ref.handleClick),t.dispatch("RELEASE_ITEM",{query:n.id})},tag:"li",name:"item",mixins:{apis:["id","interactionMethod","markedForRemoval","spawnDate","dragCenter","dragOrigin","dragOffset"],styles:["translateX","translateY","scaleX","scaleY","opacity","height"],animations:{scaleX:"spring",scaleY:"spring",translateX:_n,translateY:_n,opacity:{type:"tween",duration:150}}}}),hn=function(e,t){return Math.max(1,Math.floor((e+1)/t))},gn=function(e,t,n){if(n){var r=e.rect.element.width,o=t.length,i=null;if(0===o||n.top<t[0].rect.element.top)return-1;var a=t[0].rect.element,s=a.marginLeft+a.marginRight,u=a.width+s,l=hn(r,u);if(1===l){for(var c=0;c<o;c++){var f=t[c],d=f.rect.outer.top+.5*f.rect.element.height;if(n.top<d)return c}return o}for(var p=a.marginTop+a.marginBottom,E=a.height+p,_=0;_<o;_++){var T=_%l*u,I=Math.floor(_/l)*E,v=I-a.marginTop,m=T+u,h=I+E+a.marginBottom;if(n.top<h&&n.top>v){if(n.left<m)return _;i=_!==o-1?_:null}}return null!==i?i:o}},Rn={height:0,width:0,get getHeight(){return this.height},set setHeight(e){0!==this.height&&0!==e||(this.height=e)},get getWidth(){return this.width},set setWidth(e){0!==this.width&&0!==e||(this.width=e)},setDimensions:function(e,t){0!==this.height&&0!==e||(this.height=e),0!==this.width&&0!==t||(this.width=t)}},On=function(e,t,n){var r=arguments.length>3&&void 0!==arguments[3]?arguments[3]:0,o=arguments.length>4&&void 0!==arguments[4]?arguments[4]:1;e.dragOffset?(e.translateX=null,e.translateY=null,e.translateX=e.dragOrigin.x+e.dragOffset.x,e.translateY=e.dragOrigin.y+e.dragOffset.y,e.scaleX=1.025,e.scaleY=1.025):(e.translateX=t,e.translateY=n,Date.now()>e.spawnDate&&(0===e.opacity&&yn(e,t,n,r,o),e.scaleX=1,e.scaleY=1,e.opacity=1))},yn=function(e,t,n,r,o){e.interactionMethod===re?(e.translateX=null,e.translateX=t,e.translateY=null,e.translateY=n):e.interactionMethod===ee?(e.translateX=null,e.translateX=t-20*r,e.translateY=null,e.translateY=n-10*o,e.scaleX=.8,e.scaleY=.8):e.interactionMethod===te?(e.translateY=null,e.translateY=n-30):e.interactionMethod===J&&(e.translateX=null,e.translateX=t-30,e.translateY=null)},Dn=function(e){return e.rect.element.height+.5*e.rect.element.marginBottom+.5*e.rect.element.marginTop},Sn=A({DID_ADD_ITEM:function(e){var t=e.root,n=e.action,r=n.id,o=n.index,i=n.interactionMethod;t.ref.addIndex=o;var a=Date.now(),s=a,u=1;if(i!==re){u=0;var l=t.query("GET_ITEM_INSERT_INTERVAL"),c=a-t.ref.lastItemSpanwDate;s=c<l?a+(l-c):a}t.ref.lastItemSpanwDate=s,t.appendChildView(t.createChildView(mn,{spawnDate:s,id:r,opacity:u,interactionMethod:i}),o)},DID_REMOVE_ITEM:function(e){var t=e.root,n=e.action.id,r=t.childViews.find(function(e){return e.id===n});r&&(r.scaleX=.9,r.scaleY=.9,r.opacity=0,r.markedForRemoval=!0)},DID_DRAG_ITEM:function(e){var t=e.root,n=e.action,r=n.id,o=n.dragState,i=t.query("GET_ITEM",{id:r}),a=t.childViews.find(function(e){return e.id===r}),s=t.childViews.length,u=o.getItemIndex(i);if(a){var l,c=a.dragOrigin.x+a.dragOffset.x+a.dragCenter.x,f=a.dragOrigin.y+a.dragOffset.y+a.dragCenter.y,d=Dn(a),p=(l=a).rect.element.width+.5*l.rect.element.marginLeft+.5*l.rect.element.marginRight,E=Math.floor(t.rect.outer.width/p);E>s&&(E=s);var _=Math.floor(s/E+1);Rn.setHeight=d*_,Rn.setWidth=p*E;var T={y:Math.floor(f/d),x:Math.floor(c/p),getGridIndex:function(){return f>Rn.getHeight||f<0||c>Rn.getWidth||c<0?u:this.y*E+this.x},getColIndex:function(){for(var e=t.query("GET_ACTIVE_ITEMS"),n=t.childViews.filter(function(e){return e.rect.element.height}),r=e.map(function(e){return n.find(function(t){return t.id===e.id})}),o=r.findIndex(function(e){return e===a}),i=Dn(a),s=r.length,u=s,l=0,c=0,d=0,p=0;p<s;p++)if(l=Dn(r[p]),f<(c=(d=c)+l)){if(o>p){if(f<d+i){u=p;break}continue}u=p;break}return u}},I=E>1?T.getGridIndex():T.getColIndex();t.dispatch("MOVE_ITEM",{query:a,index:I});var v=o.getIndex();if(void 0===v||v!==I){if(o.setIndex(I),void 0===v)return;t.dispatch("DID_REORDER_ITEMS",{items:t.query("GET_ACTIVE_ITEMS"),origin:u,target:I})}}}}),An=S({create:function(e){var t=e.root;r(t.element,"role","list"),t.ref.lastItemSpanwDate=Date.now()},write:function(e){var t=e.root,n=e.props,r=e.actions,o=e.shouldOptimize;Sn({root:t,props:n,actions:r});var i=n.dragCoordinates,a=t.rect.element.width,s=t.childViews.filter(function(e){return e.rect.element.height}),u=t.query("GET_ACTIVE_ITEMS").map(function(e){return s.find(function(t){return t.id===e.id})}).filter(function(e){return e}),l=i?gn(t,u,i):null,c=t.ref.addIndex||null;t.ref.addIndex=null;var f=0,d=0,p=0;if(0!==u.length){var E=u[0].rect.element,_=E.marginTop+E.marginBottom,T=E.marginLeft+E.marginRight,I=E.width+T,v=E.height+_,m=hn(a,I);if(1===m){var h=0,g=0;u.forEach(function(e,t){if(l){var n=t-l;g=-2===n?.25*-_:-1===n?.75*-_:0===n?.75*_:1===n?.25*_:0}o&&(e.translateX=null,e.translateY=null),e.markedForRemoval||On(e,0,h+g);var r=(e.rect.element.height+_)*(e.markedForRemoval?e.opacity:1);h+=r})}else{var R=0,O=0;u.forEach(function(e,t){t===l&&(f=1),t===c&&(p+=1),e.markedForRemoval&&e.opacity<.5&&(d-=1);var n=t+p+f+d,r=n%m,i=Math.floor(n/m),a=r*I,s=i*v,u=Math.sign(a-R),E=Math.sign(s-O);R=a,O=s,e.markedForRemoval||(o&&(e.translateX=null,e.translateY=null),On(e,a,s,u,E))})}}},tag:"ul",name:"list",didWriteView:function(e){var t=e.root;t.childViews.filter(function(e){return e.markedForRemoval&&0===e.opacity&&e.resting}).forEach(function(e){e._destroy(),t.removeChildView(e)})},filterFrameActionsForChild:function(e,t){return t.filter(function(t){return!t.data||!t.data.id||e.id===t.data.id})},mixins:{apis:["dragCoordinates"]}}),Ln=A({DID_DRAG:function(e){var t=e.root,n=e.props,r=e.action;t.query("GET_ITEM_INSERT_LOCATION_FREEDOM")&&(n.dragCoordinates={left:r.position.scopeLeft-t.ref.list.rect.element.left,top:r.position.scopeTop-(t.rect.outer.top+t.rect.element.marginTop+t.rect.element.scrollTop)})},DID_END_DRAG:function(e){e.props.dragCoordinates=null}}),bn=S({create:function(e){var t=e.root,n=e.props;t.ref.list=t.appendChildView(t.createChildView(An)),n.dragCoordinates=null,n.overflowing=!1},write:function(e){var t=e.root,n=e.props,r=e.actions;if(Ln({root:t,props:n,actions:r}),t.ref.list.dragCoordinates=n.dragCoordinates,n.overflowing&&!n.overflow&&(n.overflowing=!1,t.element.dataset.state="",t.height=null),n.overflow){var o=Math.round(n.overflow);o!==t.height&&(n.overflowing=!0,t.element.dataset.state="overflow",t.height=o)}},name:"list-scroller",mixins:{apis:["overflow","dragCoordinates"],styles:["height","translateY"],animations:{translateY:"spring"}}}),Pn=function(e,t,n){var o=arguments.length>3&&void 0!==arguments[3]?arguments[3]:"";n?r(e,t,o):e.removeAttribute(t)},Mn=function(e){var t=e.root,n=e.action;t.query("GET_ALLOW_SYNC_ACCEPT_ATTRIBUTE")&&Pn(t.element,"accept",!!n.value,n.value?n.value.join(","):"")},wn=function(e){var t=e.root,n=e.action;Pn(t.element,"multiple",n.value)},Cn=function(e){var t=e.root,n=e.action;Pn(t.element,"webkitdirectory",n.value)},Nn=function(e){var t=e.root,n=t.query("GET_DISABLED"),r=t.query("GET_ALLOW_BROWSE"),o=n||!r;Pn(t.element,"disabled",o)},Gn=function(e){var t=e.root;e.action.value?0===t.query("GET_TOTAL_ITEMS")&&Pn(t.element,"required",!0):Pn(t.element,"required",!1)},Un=function(e){var t=e.root,n=e.action;Pn(t.element,"capture",!!n.value,!0===n.value?"":n.value)},Bn=function(e){var t=e.root,n=t.element;t.query("GET_TOTAL_ITEMS")>0?(Pn(n,"required",!1),Pn(n,"name",!1)):(Pn(n,"name",!0,t.query("GET_NAME")),t.query("GET_CHECK_VALIDITY")&&n.setCustomValidity(""),t.query("GET_REQUIRED")&&Pn(n,"required",!0))},Fn=S({tag:"input",name:"browser",ignoreRect:!0,ignoreRectUpdate:!0,attributes:{type:"file"},create:function(e){var t=e.root,n=e.props;t.element.id="filepond--browser-"+n.id,r(t.element,"name",t.query("GET_NAME")),r(t.element,"aria-controls","filepond--assistant-"+n.id),r(t.element,"aria-labelledby","filepond--drop-label-"+n.id),Mn({root:t,action:{value:t.query("GET_ACCEPTED_FILE_TYPES")}}),wn({root:t,action:{value:t.query("GET_ALLOW_MULTIPLE")}}),Cn({root:t,action:{value:t.query("GET_ALLOW_DIRECTORIES_ONLY")}}),Nn({root:t}),Gn({root:t,action:{value:t.query("GET_REQUIRED")}}),Un({root:t,action:{value:t.query("GET_CAPTURE_METHOD")}}),t.ref.handleChange=function(e){if(t.element.value){var r=Array.from(t.element.files).map(function(e){return e._relativePath=e.webkitRelativePath,e});setTimeout(function(){n.onload(r),function(e){if(e&&""!==e.value){try{e.value=""}catch(e){}if(e.value){var t=Ct("form"),n=e.parentNode,r=e.nextSibling;t.appendChild(e),t.reset(),r?n.insertBefore(e,r):n.appendChild(e)}}}(t.element)},250)}},t.element.addEventListener("change",t.ref.handleChange)},destroy:function(e){var t=e.root;t.element.removeEventListener("change",t.ref.handleChange)},write:A({DID_LOAD_ITEM:Bn,DID_REMOVE_ITEM:Bn,DID_THROW_ITEM_INVALID:function(e){var t=e.root;t.query("GET_CHECK_VALIDITY")&&t.element.setCustomValidity(t.query("GET_LABEL_INVALID_FIELD"))},DID_SET_DISABLED:Nn,DID_SET_ALLOW_BROWSE:Nn,DID_SET_ALLOW_DIRECTORIES_ONLY:Cn,DID_SET_ALLOW_MULTIPLE:wn,DID_SET_ACCEPTED_FILE_TYPES:Mn,DID_SET_CAPTURE_METHOD:Un,DID_SET_REQUIRED:Gn})}),qn=13,Vn=32,xn=function(e,t){e.innerHTML=t;var n=e.querySelector(".filepond--label-action");return n&&r(n,"tabindex","0"),t},Yn=S({name:"drop-label",ignoreRect:!0,create:function(e){var t=e.root,n=e.props,o=Ct("label");r(o,"for","filepond--browser-"+n.id),r(o,"id","filepond--drop-label-"+n.id),r(o,"aria-hidden","true"),t.ref.handleKeyDown=function(e){(e.keyCode===qn||e.keyCode===Vn)&&(e.preventDefault(),t.ref.label.click())},t.ref.handleClick=function(e){e.target===o||o.contains(e.target)||t.ref.label.click()},o.addEventListener("keydown",t.ref.handleKeyDown),t.element.addEventListener("click",t.ref.handleClick),xn(o,n.caption),t.appendChild(o),t.ref.label=o},destroy:function(e){var t=e.root;t.ref.label.addEventListener("keydown",t.ref.handleKeyDown),t.element.removeEventListener("click",t.ref.handleClick)},write:A({DID_SET_LABEL_IDLE:function(e){var t=e.root,n=e.action;xn(t.ref.label,n.value)}}),mixins:{styles:["opacity","translateX","translateY"],animations:{opacity:{type:"tween",duration:150},translateX:"spring",translateY:"spring"}}}),kn=S({name:"drip-blob",ignoreRect:!0,mixins:{styles:["translateX","translateY","scaleX","scaleY","opacity"],animations:{scaleX:"spring",scaleY:"spring",translateX:"spring",translateY:"spring",opacity:{type:"tween",duration:250}}}}),jn=A({DID_DRAG:function(e){var t=e.root,n=e.action;t.ref.blob?(t.ref.blob.translateX=n.position.scopeLeft,t.ref.blob.translateY=n.position.scopeTop,t.ref.blob.scaleX=1,t.ref.blob.scaleY=1,t.ref.blob.opacity=1):function(e){var t=e.root,n=.5*t.rect.element.width,r=.5*t.rect.element.height;t.ref.blob=t.appendChildView(t.createChildView(kn,{opacity:0,scaleX:2.5,scaleY:2.5,translateX:n,translateY:r}))}({root:t})},DID_DROP:function(e){var t=e.root;t.ref.blob&&(t.ref.blob.scaleX=2.5,t.ref.blob.scaleY=2.5,t.ref.blob.opacity=0)},DID_END_DRAG:function(e){var t=e.root;t.ref.blob&&(t.ref.blob.opacity=0)}}),Hn=S({ignoreRect:!0,ignoreRectUpdate:!0,name:"drip",write:function(e){var t=e.root,n=e.props,r=e.actions;jn({root:t,props:n,actions:r});var o=t.ref.blob;0===r.length&&o&&0===o.opacity&&(t.removeChildView(o),t.ref.blob=null)}}),Xn=function(e,t){try{var n=new DataTransfer;t.forEach(function(e){e instanceof File?n.items.add(e):n.items.add(new File([e],e.name,{type:e.type}))}),e.files=n.files}catch(e){return!1}return!0},Wn=function(e,t){return e.ref.fields[t]},zn=function(e){e.query("GET_ACTIVE_ITEMS").forEach(function(t){e.ref.fields[t.id]&&e.element.appendChild(e.ref.fields[t.id])})},Qn=function(e){var t=e.root;return zn(t)},Zn=A({DID_SET_DISABLED:function(e){var t=e.root;t.element.disabled=t.query("GET_DISABLED")},DID_ADD_ITEM:function(e){var t=e.root,n=e.action,r=!(t.query("GET_ITEM",n.id).origin===ve.LOCAL)&&t.query("SHOULD_UPDATE_FILE_INPUT"),o=Ct("input");o.type=r?"file":"hidden",o.name=t.query("GET_NAME"),o.disabled=t.query("GET_DISABLED"),t.ref.fields[n.id]=o,zn(t)},DID_LOAD_ITEM:function(e){var t=e.root,n=e.action,r=Wn(t,n.id);if(r&&(null!==n.serverFileReference&&(r.value=n.serverFileReference),t.query("SHOULD_UPDATE_FILE_INPUT"))){var o=t.query("GET_ITEM",n.id);Xn(r,[o.file])}},DID_REMOVE_ITEM:function(e){var t=e.root,n=e.action,r=Wn(t,n.id);r&&(r.parentNode&&r.parentNode.removeChild(r),delete t.ref.fields[n.id])},DID_DEFINE_VALUE:function(e){var t=e.root,n=e.action,r=Wn(t,n.id);r&&(null===n.value?r.removeAttribute("value"):"file"!=r.type&&(r.value=n.value),zn(t))},DID_PREPARE_OUTPUT:function(e){var t=e.root,n=e.action;t.query("SHOULD_UPDATE_FILE_INPUT")&&setTimeout(function(){var e=Wn(t,n.id);e&&Xn(e,[n.file])},0)},DID_REORDER_ITEMS:Qn,DID_SORT_ITEMS:Qn}),Kn=S({tag:"fieldset",name:"data",create:function(e){return e.root.ref.fields={}},write:Zn,ignoreRect:!0}),$n=["jpg","jpeg","png","gif","bmp","webp","svg","tiff"],Jn=["css","csv","html","txt"],er={zip:"zip|compressed",epub:"application/epub+zip"},tr=function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"";return e=e.toLowerCase(),$n.includes(e)?"image/"+("jpg"===e?"jpeg":"svg"===e?"svg+xml":e):Jn.includes(e)?"text/"+e:er[e]||""},nr=function(e){return new Promise(function(t,n){var r=dr(e);if(r.length&&!rr(e))return t(r);or(e).then(t)})},rr=function(e){return!!e.files&&e.files.length>0},or=function(e){return new Promise(function(t,n){var r=(e.items?Array.from(e.items):[]).filter(function(e){return ir(e)}).map(function(e){return ar(e)});r.length?Promise.all(r).then(function(e){var n=[];e.forEach(function(e){n.push.apply(n,e)}),t(n.filter(function(e){return e}).map(function(e){return e._relativePath||(e._relativePath=e.webkitRelativePath),e}))}).catch(console.error):t(e.files?Array.from(e.files):[])})},ir=function(e){if(cr(e)){var t=fr(e);if(t)return t.isFile||t.isDirectory}return"file"===e.kind},ar=function(e){return new Promise(function(t,n){lr(e)?sr(fr(e)).then(t).catch(n):t([e.getAsFile()])})},sr=function(e){return new Promise(function(t,n){var r=[],o=0,i=0,a=function(){0===i&&0===o&&t(r)};!function e(t){o++;var s=t.createReader();!function t(){s.readEntries(function(n){if(0===n.length)return o--,void a();n.forEach(function(t){t.isDirectory?e(t):(i++,t.file(function(e){var n=ur(e);t.fullPath&&(n._relativePath=t.fullPath),r.push(n),i--,a()}))}),t()},n)}()}(e)})},ur=function(e){if(e.type.length)return e;var t=e.lastModifiedDate,n=e.name,r=tr(je(e.name));return r.length?((e=e.slice(0,e.size,r)).name=n,e.lastModifiedDate=t,e):e},lr=function(e){return cr(e)&&(fr(e)||{}).isDirectory},cr=function(e){return"webkitGetAsEntry"in e},fr=function(e){return e.webkitGetAsEntry()},dr=function(e){var t=[];try{if((t=Er(e)).length)return t;t=pr(e)}catch(e){}return t},pr=function(e){var t=e.getData("url");return"string"==typeof t&&t.length?[t]:[]},Er=function(e){var t=e.getData("text/html");if("string"==typeof t&&t.length){var n=t.match(/src\s*=\s*"(.+?)"/);if(n)return[n[1]]}return[]},_r=[],Tr=function(e){return{pageLeft:e.pageX,pageTop:e.pageY,scopeLeft:e.offsetX||e.layerX,scopeTop:e.offsetY||e.layerY}},Ir=function(e){var t=_r.find(function(t){return t.element===e});if(t)return t;var n=vr(e);return _r.push(n),n},vr=function(e){var n=[],r={dragenter:Rr,dragover:Or,dragleave:Dr,drop:yr},o={};t(r,function(t,r){o[t]=r(e,n),e.addEventListener(t,o[t],!1)});var i={element:e,addListener:function(a){return n.push(a),function(){n.splice(n.indexOf(a),1),0===n.length&&(_r.splice(_r.indexOf(i),1),t(r,function(t){e.removeEventListener(t,o[t],!1)}))}}};return i},mr=function(e,t){var n,r=function(e,t){return"elementFromPoint"in e||(e=document),e.elementFromPoint(t.x,t.y)}("getRootNode"in(n=t)?n.getRootNode():document,{x:e.pageX-window.pageXOffset,y:e.pageY-window.pageYOffset});return r===t||t.contains(r)},hr=null,gr=function(e,t){try{e.dropEffect=t}catch(e){}},Rr=function(e,t){return function(e){e.preventDefault(),hr=e.target,t.forEach(function(t){var n=t.element,r=t.onenter;mr(e,n)&&(t.state="enter",r(Tr(e)))})}},Or=function(e,t){return function(e){e.preventDefault();var n=e.dataTransfer;nr(n).then(function(r){var o=!1;t.some(function(t){var i=t.filterElement,a=t.element,s=t.onenter,u=t.onexit,l=t.ondrag,c=t.allowdrop;gr(n,"copy");var f=c(r);if(f)if(mr(e,a)){if(o=!0,null===t.state)return t.state="enter",void s(Tr(e));if(t.state="over",i&&!f)return void gr(n,"none");l(Tr(e))}else i&&!o&&gr(n,"none"),t.state&&(t.state=null,u(Tr(e)));else gr(n,"none")})})}},yr=function(e,t){return function(e){e.preventDefault();var n=e.dataTransfer;nr(n).then(function(n){t.forEach(function(t){var r=t.filterElement,o=t.element,i=t.ondrop,a=t.onexit,s=t.allowdrop;if(t.state=null,!r||mr(e,o))return s(n)?void i(Tr(e),n):a(Tr(e))})})}},Dr=function(e,t){return function(e){hr===e.target&&t.forEach(function(t){var n=t.onexit;t.state=null,n(Tr(e))})}},Sr=function(e,t,n){e.classList.add("filepond--hopper");var r=n.catchesDropsOnPage,o=n.requiresDropOnElement,i=n.filterItems,a=void 0===i?function(e){return e}:i,s=function(e,t,n){var r=Ir(t),o={element:e,filterElement:n,state:null,ondrop:function(){},onenter:function(){},ondrag:function(){},onexit:function(){},onload:function(){},allowdrop:function(){}};return o.destroy=r.addListener(o),o}(e,r?document.documentElement:e,o),u="",l="";s.allowdrop=function(e){return t(a(e))},s.ondrop=function(e,n){var r=a(n);t(r)?(l="drag-drop",c.onload(r,e)):c.ondragend(e)},s.ondrag=function(e){c.ondrag(e)},s.onenter=function(e){l="drag-over",c.ondragstart(e)},s.onexit=function(e){l="drag-exit",c.ondragend(e)};var c={updateHopperState:function(){u!==l&&(e.dataset.hopperState=l,u=l)},onload:function(){},ondragstart:function(){},ondrag:function(){},ondragend:function(){},destroy:function(){s.destroy()}};return c},Ar=!1,Lr=[],br=function(e){var t=document.activeElement;if(t&&/textarea|input/i.test(t.nodeName)){for(var n=!1,r=t;r!==document.body;){if(r.classList.contains("filepond--root")){n=!0;break}r=r.parentNode}if(!n)return}nr(e.clipboardData).then(function(e){e.length&&Lr.forEach(function(t){return t(e)})})},Pr=function(){var e=function(e){t.onload(e)},t={destroy:function(){var t;t=e,de(Lr,Lr.indexOf(t)),0===Lr.length&&(document.removeEventListener("paste",br),Ar=!1)},onload:function(){}};return function(e){Lr.includes(e)||(Lr.push(e),Ar||(Ar=!0,document.addEventListener("paste",br)))}(e),t},Mr=null,wr=null,Cr=[],Nr=function(e,t){e.element.textContent=t},Gr=function(e,t,n){var r=e.query("GET_TOTAL_ITEMS");Nr(e,n+" "+t+", "+r+" "+(1===r?e.query("GET_LABEL_FILE_COUNT_SINGULAR"):e.query("GET_LABEL_FILE_COUNT_PLURAL"))),clearTimeout(wr),wr=setTimeout(function(){!function(e){e.element.textContent=""}(e)},1500)},Ur=function(e){return e.element.parentNode.contains(document.activeElement)},Br=function(e){var t=e.root,n=e.action,r=t.query("GET_ITEM",n.id).filename,o=t.query("GET_LABEL_FILE_PROCESSING_ABORTED");Nr(t,r+" "+o)},Fr=function(e){var t=e.root,n=e.action,r=t.query("GET_ITEM",n.id).filename;Nr(t,n.status.main+" "+r+" "+n.status.sub)},qr=S({create:function(e){var t=e.root,n=e.props;t.element.id="filepond--assistant-"+n.id,r(t.element,"role","status"),r(t.element,"aria-live","polite"),r(t.element,"aria-relevant","additions")},ignoreRect:!0,ignoreRectUpdate:!0,write:A({DID_LOAD_ITEM:function(e){var t=e.root,n=e.action;if(Ur(t)){t.element.textContent="";var r=t.query("GET_ITEM",n.id);Cr.push(r.filename),clearTimeout(Mr),Mr=setTimeout(function(){Gr(t,Cr.join(", "),t.query("GET_LABEL_FILE_ADDED")),Cr.length=0},750)}},DID_REMOVE_ITEM:function(e){var t=e.root,n=e.action;if(Ur(t)){var r=n.item;Gr(t,r.filename,t.query("GET_LABEL_FILE_REMOVED"))}},DID_COMPLETE_ITEM_PROCESSING:function(e){var t=e.root,n=e.action,r=t.query("GET_ITEM",n.id).filename,o=t.query("GET_LABEL_FILE_PROCESSING_COMPLETE");Nr(t,r+" "+o)},DID_ABORT_ITEM_PROCESSING:Br,DID_REVERT_ITEM_PROCESSING:Br,DID_THROW_ITEM_REMOVE_ERROR:Fr,DID_THROW_ITEM_LOAD_ERROR:Fr,DID_THROW_ITEM_INVALID:Fr,DID_THROW_ITEM_PROCESSING_ERROR:Fr}),tag:"span",name:"assistant"}),Vr=function(e){var t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"-";return e.replace(new RegExp(t+".","g"),function(e){return e.charAt(1).toUpperCase()})},xr=function(e){var t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:16,n=!(arguments.length>2&&void 0!==arguments[2])||arguments[2],r=Date.now(),o=null;return function(){for(var i=arguments.length,a=new Array(i),s=0;s<i;s++)a[s]=arguments[s];clearTimeout(o);var u=Date.now()-r,l=function(){r=Date.now(),e.apply(void 0,a)};u<t?n||(o=setTimeout(l,t-u)):l()}},Yr=function(e){return e.preventDefault()},kr=function(e){var t=e.ref.list.childViews[0].childViews[0];return t?{top:t.rect.element.marginTop,bottom:t.rect.element.marginBottom}:{top:0,bottom:0}},jr=function(e){var t=0,n=0,r=e.ref.list,o=r.childViews[0],i=o.childViews.filter(function(e){return e.rect.element.height}),a=e.query("GET_ACTIVE_ITEMS").map(function(e){return i.find(function(t){return t.id===e.id})}).filter(function(e){return e});if(0===a.length)return{visual:t,bounds:n};var s=o.rect.element.width,u=gn(o,a,r.dragCoordinates),l=a[0].rect.element,c=l.marginTop+l.marginBottom,f=l.marginLeft+l.marginRight,d=l.width+f,p=l.height+c,E=void 0!==u&&u>=0?1:0,_=a.find(function(e){return e.markedForRemoval&&e.opacity<.45})?-1:0,T=a.length+E+_,I=hn(s,d);return 1===I?a.forEach(function(e){var r=e.rect.element.height+c;n+=r,t+=r*e.opacity}):(n=Math.ceil(T/I)*p,t=n),{visual:t,bounds:n}},Hr=function(e){var t=e.ref.measureHeight||null;return{cappedHeight:parseInt(e.style.maxHeight,10)||null,fixedHeight:0===t?null:t}},Xr=function(e,t){var n=e.query("GET_ALLOW_REPLACE"),r=e.query("GET_ALLOW_MULTIPLE"),o=e.query("GET_TOTAL_ITEMS"),i=e.query("GET_MAX_FILES"),a=t.length;return!r&&a>1?(e.dispatch("DID_THROW_MAX_FILES",{source:t,error:ot("warning",0,"Max files")}),!0):!(!r&&n)&&(!!(V(i=r?i:1)&&o+a>i)&&(e.dispatch("DID_THROW_MAX_FILES",{source:t,error:ot("warning",0,"Max files")}),!0))},Wr=function(e,t,n){var r=e.childViews[0];return gn(r,t,{left:n.scopeLeft-r.rect.element.left,top:n.scopeTop-(e.rect.outer.top+e.rect.element.marginTop+e.rect.element.scrollTop)})},zr=function(e){var t=e.query("GET_ALLOW_DROP"),n=e.query("GET_DISABLED"),r=t&&!n;if(r&&!e.ref.hopper){var o=Sr(e.element,function(t){var n=e.query("GET_BEFORE_DROP_FILE")||function(){return!0};return!e.query("GET_DROP_VALIDATION")||t.every(function(t){return ye("ALLOW_HOPPER_ITEM",t,{query:e.query}).every(function(e){return!0===e})&&n(t)})},{filterItems:function(t){var n=e.query("GET_IGNORED_FILES");return t.filter(function(e){return!ht(e)||!n.includes(e.name.toLowerCase())})},catchesDropsOnPage:e.query("GET_DROP_ON_PAGE"),requiresDropOnElement:e.query("GET_DROP_ON_ELEMENT")});o.onload=function(t,n){var r=e.ref.list.childViews[0].childViews.filter(function(e){return e.rect.element.height}),o=e.query("GET_ACTIVE_ITEMS").map(function(e){return r.find(function(t){return t.id===e.id})}).filter(function(e){return e});Oe("ADD_ITEMS",t,{dispatch:e.dispatch}).then(function(t){if(Xr(e,t))return!1;e.dispatch("ADD_ITEMS",{items:t,index:Wr(e.ref.list,o,n),interactionMethod:ee})}),e.dispatch("DID_DROP",{position:n}),e.dispatch("DID_END_DRAG",{position:n})},o.ondragstart=function(t){e.dispatch("DID_START_DRAG",{position:t})},o.ondrag=xr(function(t){e.dispatch("DID_DRAG",{position:t})}),o.ondragend=function(t){e.dispatch("DID_END_DRAG",{position:t})},e.ref.hopper=o,e.ref.drip=e.appendChildView(e.createChildView(Hn))}else!r&&e.ref.hopper&&(e.ref.hopper.destroy(),e.ref.hopper=null,e.removeChildView(e.ref.drip))},Qr=function(e,t){var n=e.query("GET_ALLOW_BROWSE"),r=e.query("GET_DISABLED"),o=n&&!r;o&&!e.ref.browser?e.ref.browser=e.appendChildView(e.createChildView(Fn,Object.assign({},t,{onload:function(t){Oe("ADD_ITEMS",t,{dispatch:e.dispatch}).then(function(t){if(Xr(e,t))return!1;e.dispatch("ADD_ITEMS",{items:t,index:-1,interactionMethod:te})})}})),0):!o&&e.ref.browser&&(e.removeChildView(e.ref.browser),e.ref.browser=null)},Zr=function(e){var t=e.query("GET_ALLOW_PASTE"),n=e.query("GET_DISABLED"),r=t&&!n;r&&!e.ref.paster?(e.ref.paster=Pr(),e.ref.paster.onload=function(t){Oe("ADD_ITEMS",t,{dispatch:e.dispatch}).then(function(t){if(Xr(e,t))return!1;e.dispatch("ADD_ITEMS",{items:t,index:-1,interactionMethod:ne})})}):!r&&e.ref.paster&&(e.ref.paster.destroy(),e.ref.paster=null)},Kr=A({DID_SET_ALLOW_BROWSE:function(e){var t=e.root,n=e.props;Qr(t,n)},DID_SET_ALLOW_DROP:function(e){var t=e.root;zr(t)},DID_SET_ALLOW_PASTE:function(e){var t=e.root;Zr(t)},DID_SET_DISABLED:function(e){var t=e.root,n=e.props;zr(t),Zr(t),Qr(t,n),t.query("GET_DISABLED")?t.element.dataset.disabled="disabled":t.element.removeAttribute("data-disabled")}}),$r=S({name:"root",read:function(e){var t=e.root;t.ref.measure&&(t.ref.measureHeight=t.ref.measure.offsetHeight)},create:function(e){var t=e.root,n=e.props,r=t.query("GET_ID");r&&(t.element.id=r);var o=t.query("GET_CLASS_NAME");o&&o.split(" ").filter(function(e){return e.length}).forEach(function(e){t.element.classList.add(e)}),t.ref.label=t.appendChildView(t.createChildView(Yn,Object.assign({},n,{translateY:null,caption:t.query("GET_LABEL_IDLE")}))),t.ref.list=t.appendChildView(t.createChildView(bn,{translateY:null})),t.ref.panel=t.appendChildView(t.createChildView(En,{name:"panel-root"})),t.ref.assistant=t.appendChildView(t.createChildView(qr,Object.assign({},n))),t.ref.data=t.appendChildView(t.createChildView(Kn,Object.assign({},n))),t.ref.measure=Ct("div"),t.ref.measure.style.height="100%",t.element.appendChild(t.ref.measure),t.ref.bounds=null,t.query("GET_STYLES").filter(function(e){return!M(e.value)}).map(function(e){var n=e.name,r=e.value;t.element.dataset[n]=r}),t.ref.widthPrevious=null,t.ref.widthUpdated=xr(function(){t.ref.updateHistory=[],t.dispatch("DID_RESIZE_ROOT")},250),t.ref.previousAspectRatio=null,t.ref.updateHistory=[];var i=window.matchMedia("(pointer: fine) and (hover: hover)").matches,a="PointerEvent"in window;t.query("GET_ALLOW_REORDER")&&a&&!i&&(t.element.addEventListener("touchmove",Yr,{passive:!1}),t.element.addEventListener("gesturestart",Yr));var s=t.query("GET_CREDITS");if(2===s.length){var u=document.createElement("a");u.className="filepond--credits",u.setAttribute("aria-hidden","true"),u.href=s[0],u.tabindex=-1,u.target="_blank",u.rel="noopener noreferrer",u.textContent=s[1],t.element.appendChild(u),t.ref.credits=u}},write:function(e){var t=e.root,n=e.props,r=e.actions;if(Kr({root:t,props:n,actions:r}),r.filter(function(e){return/^DID_SET_STYLE_/.test(e.type)}).filter(function(e){return!M(e.data.value)}).map(function(e){var n=e.type,r=e.data,o=Vr(n.substring(8).toLowerCase(),"_");t.element.dataset[o]=r.value,t.invalidateLayout()}),!t.rect.element.hidden){t.rect.element.width!==t.ref.widthPrevious&&(t.ref.widthPrevious=t.rect.element.width,t.ref.widthUpdated());var o=t.ref.bounds;o||(o=t.ref.bounds=Hr(t),t.element.removeChild(t.ref.measure),t.ref.measure=null);var i=t.ref,a=i.hopper,s=i.label,u=i.list,l=i.panel;a&&a.updateHopperState();var c=t.query("GET_PANEL_ASPECT_RATIO"),f=t.query("GET_ALLOW_MULTIPLE"),d=t.query("GET_TOTAL_ITEMS"),p=d===(f?t.query("GET_MAX_FILES")||1e6:1),E=r.find(function(e){return"DID_ADD_ITEM"===e.type});if(p&&E){var _=E.data.interactionMethod;s.opacity=0,f?s.translateY=-40:_===J?s.translateX=40:s.translateY=_===te?40:30}else p||(s.opacity=1,s.translateX=0,s.translateY=0);var T=kr(t),I=jr(t),v=s.rect.element.height,m=!f||p?0:v,h=p?u.rect.element.marginTop:0,g=0===d?0:u.rect.element.marginBottom,R=m+h+I.visual+g,O=m+h+I.bounds+g;if(u.translateY=Math.max(0,m-u.rect.element.marginTop)-T.top,c){var y=t.rect.element.width,D=y*c;c!==t.ref.previousAspectRatio&&(t.ref.previousAspectRatio=c,t.ref.updateHistory=[]);var S=t.ref.updateHistory;if(S.push(y),S.length>4)for(var A=S.length,L=A-10,b=0,P=A;P>=L;P--)if(S[P]===S[P-2]&&b++,b>=2)return;l.scalable=!1,l.height=D;var w=D-m-(g-T.bottom)-(p?h:0);I.visual>w?u.overflow=w:u.overflow=null,t.height=D}else if(o.fixedHeight){l.scalable=!1;var C=o.fixedHeight-m-(g-T.bottom)-(p?h:0);I.visual>C?u.overflow=C:u.overflow=null}else if(o.cappedHeight){var N=R>=o.cappedHeight,G=Math.min(o.cappedHeight,R);l.scalable=!0,l.height=N?G:G-T.top-T.bottom;var U=G-m-(g-T.bottom)-(p?h:0);R>o.cappedHeight&&I.visual>U?u.overflow=U:u.overflow=null,t.height=Math.min(o.cappedHeight,O-T.top-T.bottom)}else{var B=d>0?T.top+T.bottom:0;l.scalable=!0,l.height=Math.max(v,R-B),t.height=Math.max(v,O-B)}t.ref.credits&&l.heightCurrent&&(t.ref.credits.style.transform="translateY("+l.heightCurrent+"px)")}},destroy:function(e){var t=e.root;t.ref.paster&&t.ref.paster.destroy(),t.ref.hopper&&t.ref.hopper.destroy(),t.element.removeEventListener("touchmove",Yr),t.element.removeEventListener("gesturestart",Yr)},mixins:{styles:["height"]}}),Jr=function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{},r=null,o=Se(),i=function(e){var t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:[],n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:[],r=Object.assign({},e),o=[],i=[],a=function(e,t,n){!n||document.hidden?(c[e]&&c[e](t),o.push({type:e,data:t})):i.push({type:e,data:t})},s=function(e){for(var t,n=arguments.length,r=new Array(n>1?n-1:0),o=1;o<n;o++)r[o-1]=arguments[o];return l[e]?(t=l)[e].apply(t,r):null},u={getState:function(){return Object.assign({},r)},processActionQueue:function(){var e=[].concat(o);return o.length=0,e},processDispatchQueue:function(){var e=[].concat(i);i.length=0,e.forEach(function(e){var t=e.type,n=e.data;a(t,n)})},dispatch:a,query:s},l={};t.forEach(function(e){l=Object.assign({},e(r),{},l)});var c={};return n.forEach(function(e){c=Object.assign({},e(a,s,r),{},c)}),u}({items:[],listUpdateTimeout:null,itemUpdateTimeout:null,processingQueue:[],options:Q(o)},[Ve,$(o)],[Pt,K(o)]);i.dispatch("SET_OPTIONS",{options:e});var a=function(){document.hidden||i.dispatch("KICK")};document.addEventListener("visibilitychange",a);var s=null,u=!1,l=!1,c=null,f=null,d=function(){u||(u=!0),clearTimeout(s),s=setTimeout(function(){u=!1,c=null,f=null,l&&(l=!1,i.dispatch("DID_STOP_RESIZE"))},500)};window.addEventListener("resize",d);var p=$r(i,{id:oe()}),E=!1,T=!1,I={_read:function(){u&&(f=window.innerWidth,c||(c=f),l||f===c||(i.dispatch("DID_START_RESIZE"),l=!0)),T&&E&&(E=null===p.element.offsetParent),E||(p._read(),T=p.rect.element.hidden)},_write:function(e){var t,n=i.processActionQueue().filter(function(e){return!/^SET_/.test(e.type)});E&&!n.length||(g(n),E=p._write(e,n,l),(t=i.query("GET_ITEMS")).forEach(function(e,n){e.released&&de(t,n)}),E&&i.processDispatchQueue())}},v=function(e){return function(t){var n={type:e};if(!t)return n;if(t.hasOwnProperty("error")&&(n.error=t.error?Object.assign({},t.error):null),t.status&&(n.status=Object.assign({},t.status)),t.file&&(n.output=t.file),t.source)n.file=t.source;else if(t.item||t.id){var r=t.item?t.item:i.query("GET_ITEM",t.id);n.file=r?Te(r):null}return t.items&&(n.items=t.items.map(Te)),/progress/.test(e)&&(n.progress=t.progress),t.hasOwnProperty("origin")&&t.hasOwnProperty("target")&&(n.origin=t.origin,n.target=t.target),n}},m={DID_DESTROY:v("destroy"),DID_INIT:v("init"),DID_THROW_MAX_FILES:v("warning"),DID_INIT_ITEM:v("initfile"),DID_START_ITEM_LOAD:v("addfilestart"),DID_UPDATE_ITEM_LOAD_PROGRESS:v("addfileprogress"),DID_LOAD_ITEM:v("addfile"),DID_THROW_ITEM_INVALID:[v("error"),v("addfile")],DID_THROW_ITEM_LOAD_ERROR:[v("error"),v("addfile")],DID_THROW_ITEM_REMOVE_ERROR:[v("error"),v("removefile")],DID_PREPARE_OUTPUT:v("preparefile"),DID_START_ITEM_PROCESSING:v("processfilestart"),DID_UPDATE_ITEM_PROCESS_PROGRESS:v("processfileprogress"),DID_ABORT_ITEM_PROCESSING:v("processfileabort"),DID_COMPLETE_ITEM_PROCESSING:v("processfile"),DID_COMPLETE_ITEM_PROCESSING_ALL:v("processfiles"),DID_REVERT_ITEM_PROCESSING:v("processfilerevert"),DID_THROW_ITEM_PROCESSING_ERROR:[v("error"),v("processfile")],DID_REMOVE_ITEM:v("removefile"),DID_UPDATE_ITEMS:v("updatefiles"),DID_ACTIVATE_ITEM:v("activatefile"),DID_REORDER_ITEMS:v("reorderfiles")},h=function(e){var t=Object.assign({pond:A},e);delete t.type,p.element.dispatchEvent(new CustomEvent("FilePond:"+e.type,{detail:t,bubbles:!0,cancelable:!0,composed:!0}));var n=[];e.hasOwnProperty("error")&&n.push(e.error),e.hasOwnProperty("file")&&n.push(e.file);var r=["type","error","file"];Object.keys(e).filter(function(e){return!r.includes(e)}).forEach(function(t){return n.push(e[t])}),A.fire.apply(A,[e.type].concat(n));var o=i.query("GET_ON"+e.type.toUpperCase());o&&o.apply(void 0,n)},g=function(e){e.length&&e.filter(function(e){return m[e.type]}).forEach(function(e){var t=m[e.type];(Array.isArray(t)?t:[t]).forEach(function(t){"DID_INIT_ITEM"===e.type?h(t(e.data)):setTimeout(function(){h(t(e.data))},0)})})},R=function(e){return new Promise(function(t,n){i.dispatch("REQUEST_ITEM_PREPARE",{query:e,success:function(e){t(e)},failure:function(e){n(e)}})})},O=function(e,t){var n;return"object"!=typeof e||(n=e).file&&n.id||t||(t=e,e=void 0),i.dispatch("REMOVE_ITEM",Object.assign({},t,{query:e})),null===i.query("GET_ACTIVE_ITEM",e)},y=function(){for(var e=arguments.length,t=new Array(e),n=0;n<e;n++)t[n]=arguments[n];return new Promise(function(e,n){var r=[],o={};if(P(t[0]))r.push.apply(r,t[0]),Object.assign(o,t[1]||{});else{var a=t[t.length-1];"object"!=typeof a||a instanceof Blob||Object.assign(o,t.pop()),r.push.apply(r,t)}i.dispatch("ADD_ITEMS",{items:r,index:o.index,interactionMethod:J,success:e,failure:n})})},D=function(){return i.query("GET_ACTIVE_ITEMS")},S=function(e){return new Promise(function(t,n){i.dispatch("REQUEST_ITEM_PROCESSING",{query:e,success:function(e){t(e)},failure:function(e){n(e)}})})},A=Object.assign({},pe(),{},I,{},function(e,n){var r={};return t(n,function(t){r[t]={get:function(){return e.getState().options[t]},set:function(n){e.dispatch("SET_"+Z(t,"_").toUpperCase(),{value:n})}}}),r}(i,o),{setOptions:function(e){return i.dispatch("SET_OPTIONS",{options:e})},addFile:function(e){var t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{};return new Promise(function(n,r){y([{source:e,options:t}],{index:t.index}).then(function(e){return n(e&&e[0])}).catch(r)})},addFiles:y,getFile:function(e){return i.query("GET_ACTIVE_ITEM",e)},processFile:S,prepareFile:R,removeFile:O,moveFile:function(e,t){return i.dispatch("MOVE_ITEM",{query:e,index:t})},getFiles:D,processFiles:function(){for(var e=arguments.length,t=new Array(e),n=0;n<e;n++)t[n]=arguments[n];var r=Array.isArray(t[0])?t[0]:t;if(!r.length){var o=D().filter(function(e){return!(e.status===Ie.IDLE&&e.origin===ve.LOCAL)&&e.status!==Ie.PROCESSING&&e.status!==Ie.PROCESSING_COMPLETE&&e.status!==Ie.PROCESSING_REVERT_ERROR});return Promise.all(o.map(S))}return Promise.all(r.map(S))},removeFiles:function(){for(var e=arguments.length,t=new Array(e),n=0;n<e;n++)t[n]=arguments[n];var r,o=Array.isArray(t[0])?t[0]:t;"object"==typeof o[o.length-1]?r=o.pop():Array.isArray(t[0])&&(r=t[1]);var i=D();return o.length?o.map(function(e){return _(e)?i[e]?i[e].id:null:e}).filter(function(e){return e}).map(function(e){return O(e,r)}):Promise.all(i.map(function(e){return O(e,r)}))},prepareFiles:function(){for(var e=arguments.length,t=new Array(e),n=0;n<e;n++)t[n]=arguments[n];var r=Array.isArray(t[0])?t[0]:t,o=r.length?r:D();return Promise.all(o.map(R))},sort:function(e){return i.dispatch("SORT",{compare:e})},browse:function(){var e=p.element.querySelector("input[type=file]");e&&e.click()},destroy:function(){A.fire("destroy",p.element),i.dispatch("ABORT_ALL"),p._destroy(),window.removeEventListener("resize",d),document.removeEventListener("visibilitychange",a),i.dispatch("DID_DESTROY")},insertBefore:function(e){return L(p.element,e)},insertAfter:function(e){return b(p.element,e)},appendTo:function(e){return e.appendChild(p.element)},replaceElement:function(e){L(p.element,e),e.parentNode.removeChild(e),r=e},restoreElement:function(){r&&(b(r,p.element),p.element.parentNode.removeChild(p.element),r=null)},isAttachedTo:function(e){return p.element===e||r===e},element:{get:function(){return p.element}},status:{get:function(){return i.query("GET_STATUS")}}});return i.dispatch("DID_INIT"),n(A)},eo=function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{},n={};return t(Se(),function(e,t){n[e]=t[0]}),Jr(Object.assign({},n,{},e))},to=function(e){var n=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{},o=[];t(e.attributes,function(t){o.push(e.attributes[t])});var i=o.filter(function(e){return e.name}).reduce(function(t,n){var o,i=r(e,n.name);return t[(o=n.name,Vr(o.replace(/^data-/,"")))]=i===n.name||i,t},{});return function e(n,r){t(r,function(r,o){t(n,function(e,t){var i=new RegExp(r);if(i.test(e)&&(delete n[e],!1!==o))if(U(o))n[o]=t;else{var a,s=o.group;H(o)&&!n[s]&&(n[s]={}),n[s][(a=e.replace(i,""),a.charAt(0).toLowerCase()+a.slice(1))]=t}}),o.mapping&&e(n[o.group],o.mapping)})}(i,n),i},no=function(){return(arguments.length<=0?void 0:arguments[0])instanceof HTMLElement?function(e){var t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{},n={"^class$":"className","^multiple$":"allowMultiple","^capture$":"captureMethod","^webkitdirectory$":"allowDirectoriesOnly","^server":{group:"server",mapping:{"^process":{group:"process"},"^revert":{group:"revert"},"^fetch":{group:"fetch"},"^restore":{group:"restore"},"^load":{group:"load"}}},"^type$":!1,"^files$":!1};ye("SET_ATTRIBUTE_TO_OPTION_MAP",n);var r=Object.assign({},t),o=to("FIELDSET"===e.nodeName?e.querySelector("input[type=file]"):e,n);Object.keys(o).forEach(function(e){H(o[e])?(H(r[e])||(r[e]={}),Object.assign(r[e],o[e])):r[e]=o[e]}),r.files=(t.files||[]).concat(Array.from(e.querySelectorAll("input:not([type=file])")).map(function(e){return{source:e.value,options:{type:e.dataset.type}}}));var i=eo(r);return e.files&&Array.from(e.files).forEach(function(e){i.addFile(e)}),i.replaceElement(e),i}.apply(void 0,arguments):eo.apply(void 0,arguments)},ro=["fire","_read","_write"],oo=function(e){var t={};return Ee(e,t,ro),t},io=function(e,t){return e.replace(/(?:{([a-zA-Z]+)})/g,function(e,n){return t[n]})},ao=function(e){var t=new Blob(["(",e.toString(),")()"],{type:"application/javascript"}),n=URL.createObjectURL(t),r=new Worker(n);return{transfer:function(e,t){},post:function(e,t,n){var o=oe();r.onmessage=function(e){e.data.id===o&&t(e.data.message)},r.postMessage({id:o,message:e},n)},terminate:function(){r.terminate(),URL.revokeObjectURL(n)}}},so=function(e){return new Promise(function(t,n){var r=new Image;r.onload=function(){t(r)},r.onerror=function(e){n(e)},r.src=e})},uo=function(e,t){var n=e.slice(0,e.size,e.type);return n.lastModifiedDate=e.lastModifiedDate,n.name=t,n},lo=function(e){return uo(e,e.name)},co=[],fo=function(e){if(!co.includes(e)){co.push(e);var n,r=e({addFilter:De,utils:{Type:ge,forin:t,isString:U,isFile:ht,toNaturalFileSize:qt,replaceInString:io,getExtensionFromFilename:je,getFilenameWithoutExtension:mt,guesstimateMimeType:tr,getFileFromBlob:We,getFilenameFromURL:ke,createRoute:A,createWorker:ao,createView:S,createItemAPI:Te,loadImage:so,copyFile:lo,renameFile:uo,createBlob:ze,applyFilterChain:Oe,text:Nt,getNumericAspectRatioFromString:be},views:{fileActionButton:Ft}});n=r.options,Object.assign(Ae,n)}},po=(Kt=c()&&!("[object OperaMini]"===Object.prototype.toString.call(window.operamini))&&"visibilityState"in document&&"Promise"in window&&"slice"in Blob.prototype&&"URL"in window&&"createObjectURL"in window.URL&&"performance"in window&&("supports"in(window.CSS||{})||/MSIE|Trident/.test(window.navigator.userAgent)),function(){return Kt}),Eo={apps:[]},_o=function(){};if(e.Status={},e.FileStatus={},e.FileOrigin={},e.OptionTypes={},e.create=_o,e.destroy=_o,e.parse=_o,e.find=_o,e.registerPlugin=_o,e.getOptions=_o,e.setOptions=_o,po()){!function(e,t){var n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:60,r="__framePainter";if(window[r])return window[r].readers.push(e),void window[r].writers.push(t);window[r]={readers:[e],writers:[t]};var o=window[r],i=1e3/n,a=null,s=null,u=null,l=null,c=function(){document.hidden?(u=function(){return window.setTimeout(function(){return f(performance.now())},i)},l=function(){return window.clearTimeout(s)}):(u=function(){return window.requestAnimationFrame(f)},l=function(){return window.cancelAnimationFrame(s)})};document.addEventListener("visibilitychange",function(){l&&l(),c(),f(performance.now())});var f=function e(t){s=u(e),a||(a=t);var n=t-a;n<=i||(a=t-n%i,o.readers.forEach(function(e){return e()}),o.writers.forEach(function(e){return e(t)}))};c(),f(performance.now())}(function(){Eo.apps.forEach(function(e){return e._read()})},function(e){Eo.apps.forEach(function(t){return t._write(e)})});var To=function t(){document.dispatchEvent(new CustomEvent("FilePond:loaded",{detail:{supported:po,create:e.create,destroy:e.destroy,parse:e.parse,find:e.find,registerPlugin:e.registerPlugin,setOptions:e.setOptions}})),document.removeEventListener("DOMContentLoaded",t)};"loading"!==document.readyState?setTimeout(function(){return To()},0):document.addEventListener("DOMContentLoaded",To);var Io=function(){return t(Se(),function(t,n){e.OptionTypes[t]=n[1]})};e.Status=Object.assign({},Me),e.FileOrigin=Object.assign({},ve),e.FileStatus=Object.assign({},Ie),e.OptionTypes={},Io(),e.create=function(){var t=no.apply(void 0,arguments);return t.on("destroy",e.destroy),Eo.apps.push(t),oo(t)},e.destroy=function(e){var t=Eo.apps.findIndex(function(t){return t.isAttachedTo(e)});return t>=0&&(Eo.apps.splice(t,1)[0].restoreElement(),!0)},e.parse=function(t){return Array.from(t.querySelectorAll(".filepond")).filter(function(e){return!Eo.apps.find(function(t){return t.isAttachedTo(e)})}).map(function(t){return e.create(t)})},e.find=function(e){var t=Eo.apps.find(function(t){return t.isAttachedTo(e)});return t?oo(t):null},e.registerPlugin=function(){for(var e=arguments.length,t=new Array(e),n=0;n<e;n++)t[n]=arguments[n];t.forEach(fo),Io()},e.getOptions=function(){var e={};return t(Se(),function(t,n){e[t]=n[0]}),e},e.setOptions=function(n){return H(n)&&(Eo.apps.forEach(function(e){e.setOptions(n)}),function(e){t(e,function(e,t){Ae[e]&&(Ae[e][0]=z(t,Ae[e][0],Ae[e][1]))})}(n)),e.getOptions()}}e.supported=po,Object.defineProperty(e,"__esModule",{value:!0})});

/*
 * jQuery FilePond 1.0.0
 * Licensed under MIT, https://opensource.org/licenses/MIT
 * Please visit https://pqina.nl/filepond for details.
 */
(function ($, FilePond) {
    'use strict';

    // No jQuery No Go
    if (!$ || !FilePond) {
        return;
    }

    // Test if FilePond is supported
    if (!FilePond.supported()) {
        // add stub
        $.fn.filepond = function () { };
        return;
    }

    // Helpers
    function argsToArray(args) {
        return Array.prototype.slice.call(args);
    }

    function isFactory(args) {
        return !args.length || typeof args[0] === 'object';
    }

    function isGetter(obj, key) {
        var descriptor = Object.getOwnPropertyDescriptor(obj, key);
        return descriptor ? typeof descriptor.get !== 'undefined' : false;
    }

    function isSetter(obj, key) {
        var descriptor = Object.getOwnPropertyDescriptor(obj, key);
        return descriptor ? typeof descriptor.set !== 'undefined' : false;
    }

    function isMethod(obj, key) {
        return typeof obj[key] === 'function';
    }

    // Setup plugin
    $.fn.filepond = function () {

        // get arguments as array
        var args = argsToArray(arguments);

        // method results array
        var results = [];

        // Execute for every item in the list
        var items = this.each(function () {

            // test if is create call
            if (isFactory(args)) {
                FilePond.create(this, args[0])
                return;
            }

            // get a reference to the pond instance based on the element
            var pond = FilePond.find(this);

            // if no pond found, exit here
            if (!pond) {
                return;
            }

            // get property name or method name
            var key = args[0];

            // get params to pass
            var params = args.concat().slice(1);

            // run method
            if (isMethod(pond, key)) {
                results.push(pond[key].apply(pond, params));
                return;
            }

            // set setter
            if (isSetter(pond, key) && params.length) {
                pond[key] = params[0];
                return;
            }

            // get getter
            if (isGetter(pond, key)) {
                results.push(pond[key]);
                return;
            }

            console.warn('$().filepond("' + key + '") is an unknown property or method.');
        });

        // returns a jQuery object if no results returned
        return results.length ? this.length === 1 ? results[0] : results : items;
    };

    // Static API
    Object.keys(FilePond).forEach(function (key) {
        $.fn.filepond[key] = FilePond[key];
    });

    // Redirect setDefaults to setOptions
    $.fn.filepond.setDefaults = FilePond.setOptions;

}(jQuery, FilePond));


/*!
 * FilePondPluginImagePreview 4.6.12
 * Licensed under MIT, https://opensource.org/licenses/MIT/
 * Please visit https://pqina.nl/filepond/ for details.
 */

/* eslint-disable */

(function(global, factory) {
    typeof exports === 'object' && typeof module !== 'undefined'
        ? (module.exports = factory())
        : typeof define === 'function' && define.amd
            ? define(factory)
            : ((global = global || self),
                (global.FilePondPluginImagePreview = factory()));
})(this, function() {
    'use strict';

    // test if file is of type image and can be viewed in canvas
    var isPreviewableImage = function isPreviewableImage(file) {
        return /^image/.test(file.type);
    };

    function _typeof(obj) {
        if (typeof Symbol === 'function' && typeof Symbol.iterator === 'symbol') {
            _typeof = function(obj) {
                return typeof obj;
            };
        } else {
            _typeof = function(obj) {
                return obj &&
                typeof Symbol === 'function' &&
                obj.constructor === Symbol &&
                obj !== Symbol.prototype
                    ? 'symbol'
                    : typeof obj;
            };
        }

        return _typeof(obj);
    }

    var REACT_ELEMENT_TYPE;

    function _jsx(type, props, key, children) {
        if (!REACT_ELEMENT_TYPE) {
            REACT_ELEMENT_TYPE =
                (typeof Symbol === 'function' &&
                    Symbol.for &&
                    Symbol.for('react.element')) ||
                0xeac7;
        }

        var defaultProps = type && type.defaultProps;
        var childrenLength = arguments.length - 3;

        if (!props && childrenLength !== 0) {
            props = {
                children: void 0
            };
        }

        if (props && defaultProps) {
            for (var propName in defaultProps) {
                if (props[propName] === void 0) {
                    props[propName] = defaultProps[propName];
                }
            }
        } else if (!props) {
            props = defaultProps || {};
        }

        if (childrenLength === 1) {
            props.children = children;
        } else if (childrenLength > 1) {
            var childArray = new Array(childrenLength);

            for (var i = 0; i < childrenLength; i++) {
                childArray[i] = arguments[i + 3];
            }

            props.children = childArray;
        }

        return {
            $$typeof: REACT_ELEMENT_TYPE,
            type: type,
            key: key === undefined ? null : '' + key,
            ref: null,
            props: props,
            _owner: null
        };
    }

    function _asyncIterator(iterable) {
        var method;

        if (typeof Symbol === 'function') {
            if (Symbol.asyncIterator) {
                method = iterable[Symbol.asyncIterator];
                if (method != null) return method.call(iterable);
            }

            if (Symbol.iterator) {
                method = iterable[Symbol.iterator];
                if (method != null) return method.call(iterable);
            }
        }

        throw new TypeError('Object is not async iterable');
    }

    function _AwaitValue(value) {
        this.wrapped = value;
    }

    function _AsyncGenerator(gen) {
        var front, back;

        function send(key, arg) {
            return new Promise(function(resolve, reject) {
                var request = {
                    key: key,
                    arg: arg,
                    resolve: resolve,
                    reject: reject,
                    next: null
                };

                if (back) {
                    back = back.next = request;
                } else {
                    front = back = request;
                    resume(key, arg);
                }
            });
        }

        function resume(key, arg) {
            try {
                var result = gen[key](arg);
                var value = result.value;
                var wrappedAwait = value instanceof _AwaitValue;
                Promise.resolve(wrappedAwait ? value.wrapped : value).then(
                    function(arg) {
                        if (wrappedAwait) {
                            resume('next', arg);
                            return;
                        }

                        settle(result.done ? 'return' : 'normal', arg);
                    },
                    function(err) {
                        resume('throw', err);
                    }
                );
            } catch (err) {
                settle('throw', err);
            }
        }

        function settle(type, value) {
            switch (type) {
                case 'return':
                    front.resolve({
                        value: value,
                        done: true
                    });
                    break;

                case 'throw':
                    front.reject(value);
                    break;

                default:
                    front.resolve({
                        value: value,
                        done: false
                    });
                    break;
            }

            front = front.next;

            if (front) {
                resume(front.key, front.arg);
            } else {
                back = null;
            }
        }

        this._invoke = send;

        if (typeof gen.return !== 'function') {
            this.return = undefined;
        }
    }

    if (typeof Symbol === 'function' && Symbol.asyncIterator) {
        _AsyncGenerator.prototype[Symbol.asyncIterator] = function() {
            return this;
        };
    }

    _AsyncGenerator.prototype.next = function(arg) {
        return this._invoke('next', arg);
    };

    _AsyncGenerator.prototype.throw = function(arg) {
        return this._invoke('throw', arg);
    };

    _AsyncGenerator.prototype.return = function(arg) {
        return this._invoke('return', arg);
    };

    function _wrapAsyncGenerator(fn) {
        return function() {
            return new _AsyncGenerator(fn.apply(this, arguments));
        };
    }

    function _awaitAsyncGenerator(value) {
        return new _AwaitValue(value);
    }

    function _asyncGeneratorDelegate(inner, awaitWrap) {
        var iter = {},
            waiting = false;

        function pump(key, value) {
            waiting = true;
            value = new Promise(function(resolve) {
                resolve(inner[key](value));
            });
            return {
                done: false,
                value: awaitWrap(value)
            };
        }

        if (typeof Symbol === 'function' && Symbol.iterator) {
            iter[Symbol.iterator] = function() {
                return this;
            };
        }

        iter.next = function(value) {
            if (waiting) {
                waiting = false;
                return value;
            }

            return pump('next', value);
        };

        if (typeof inner.throw === 'function') {
            iter.throw = function(value) {
                if (waiting) {
                    waiting = false;
                    throw value;
                }

                return pump('throw', value);
            };
        }

        if (typeof inner.return === 'function') {
            iter.return = function(value) {
                return pump('return', value);
            };
        }

        return iter;
    }

    function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) {
        try {
            var info = gen[key](arg);
            var value = info.value;
        } catch (error) {
            reject(error);
            return;
        }

        if (info.done) {
            resolve(value);
        } else {
            Promise.resolve(value).then(_next, _throw);
        }
    }

    function _asyncToGenerator(fn) {
        return function() {
            var self = this,
                args = arguments;
            return new Promise(function(resolve, reject) {
                var gen = fn.apply(self, args);

                function _next(value) {
                    asyncGeneratorStep(
                        gen,
                        resolve,
                        reject,
                        _next,
                        _throw,
                        'next',
                        value
                    );
                }

                function _throw(err) {
                    asyncGeneratorStep(gen, resolve, reject, _next, _throw, 'throw', err);
                }

                _next(undefined);
            });
        };
    }

    function _classCallCheck(instance, Constructor) {
        if (!(instance instanceof Constructor)) {
            throw new TypeError('Cannot call a class as a function');
        }
    }

    function _defineProperties(target, props) {
        for (var i = 0; i < props.length; i++) {
            var descriptor = props[i];
            descriptor.enumerable = descriptor.enumerable || false;
            descriptor.configurable = true;
            if ('value' in descriptor) descriptor.writable = true;
            Object.defineProperty(target, descriptor.key, descriptor);
        }
    }

    function _createClass(Constructor, protoProps, staticProps) {
        if (protoProps) _defineProperties(Constructor.prototype, protoProps);
        if (staticProps) _defineProperties(Constructor, staticProps);
        return Constructor;
    }

    function _defineEnumerableProperties(obj, descs) {
        for (var key in descs) {
            var desc = descs[key];
            desc.configurable = desc.enumerable = true;
            if ('value' in desc) desc.writable = true;
            Object.defineProperty(obj, key, desc);
        }

        if (Object.getOwnPropertySymbols) {
            var objectSymbols = Object.getOwnPropertySymbols(descs);

            for (var i = 0; i < objectSymbols.length; i++) {
                var sym = objectSymbols[i];
                var desc = descs[sym];
                desc.configurable = desc.enumerable = true;
                if ('value' in desc) desc.writable = true;
                Object.defineProperty(obj, sym, desc);
            }
        }

        return obj;
    }

    function _defaults(obj, defaults) {
        var keys = Object.getOwnPropertyNames(defaults);

        for (var i = 0; i < keys.length; i++) {
            var key = keys[i];
            var value = Object.getOwnPropertyDescriptor(defaults, key);

            if (value && value.configurable && obj[key] === undefined) {
                Object.defineProperty(obj, key, value);
            }
        }

        return obj;
    }

    function _defineProperty(obj, key, value) {
        if (key in obj) {
            Object.defineProperty(obj, key, {
                value: value,
                enumerable: true,
                configurable: true,
                writable: true
            });
        } else {
            obj[key] = value;
        }

        return obj;
    }

    function _extends() {
        _extends =
            Object.assign ||
            function(target) {
                for (var i = 1; i < arguments.length; i++) {
                    var source = arguments[i];

                    for (var key in source) {
                        if (Object.prototype.hasOwnProperty.call(source, key)) {
                            target[key] = source[key];
                        }
                    }
                }

                return target;
            };

        return _extends.apply(this, arguments);
    }

    function _objectSpread(target) {
        for (var i = 1; i < arguments.length; i++) {
            var source = arguments[i] != null ? arguments[i] : {};
            var ownKeys = Object.keys(source);

            if (typeof Object.getOwnPropertySymbols === 'function') {
                ownKeys = ownKeys.concat(
                    Object.getOwnPropertySymbols(source).filter(function(sym) {
                        return Object.getOwnPropertyDescriptor(source, sym).enumerable;
                    })
                );
            }

            ownKeys.forEach(function(key) {
                _defineProperty(target, key, source[key]);
            });
        }

        return target;
    }

    function _inherits(subClass, superClass) {
        if (typeof superClass !== 'function' && superClass !== null) {
            throw new TypeError('Super expression must either be null or a function');
        }

        subClass.prototype = Object.create(superClass && superClass.prototype, {
            constructor: {
                value: subClass,
                writable: true,
                configurable: true
            }
        });
        if (superClass) _setPrototypeOf(subClass, superClass);
    }

    function _inheritsLoose(subClass, superClass) {
        subClass.prototype = Object.create(superClass.prototype);
        subClass.prototype.constructor = subClass;
        subClass.__proto__ = superClass;
    }

    function _getPrototypeOf(o) {
        _getPrototypeOf = Object.setPrototypeOf
            ? Object.getPrototypeOf
            : function _getPrototypeOf(o) {
                return o.__proto__ || Object.getPrototypeOf(o);
            };
        return _getPrototypeOf(o);
    }

    function _setPrototypeOf(o, p) {
        _setPrototypeOf =
            Object.setPrototypeOf ||
            function _setPrototypeOf(o, p) {
                o.__proto__ = p;
                return o;
            };

        return _setPrototypeOf(o, p);
    }

    function isNativeReflectConstruct() {
        if (typeof Reflect === 'undefined' || !Reflect.construct) return false;
        if (Reflect.construct.sham) return false;
        if (typeof Proxy === 'function') return true;

        try {
            Date.prototype.toString.call(Reflect.construct(Date, [], function() {}));
            return true;
        } catch (e) {
            return false;
        }
    }

    function _construct(Parent, args, Class) {
        if (isNativeReflectConstruct()) {
            _construct = Reflect.construct;
        } else {
            _construct = function _construct(Parent, args, Class) {
                var a = [null];
                a.push.apply(a, args);
                var Constructor = Function.bind.apply(Parent, a);
                var instance = new Constructor();
                if (Class) _setPrototypeOf(instance, Class.prototype);
                return instance;
            };
        }

        return _construct.apply(null, arguments);
    }

    function _isNativeFunction(fn) {
        return Function.toString.call(fn).indexOf('[native code]') !== -1;
    }

    function _wrapNativeSuper(Class) {
        var _cache = typeof Map === 'function' ? new Map() : undefined;

        _wrapNativeSuper = function _wrapNativeSuper(Class) {
            if (Class === null || !_isNativeFunction(Class)) return Class;

            if (typeof Class !== 'function') {
                throw new TypeError(
                    'Super expression must either be null or a function'
                );
            }

            if (typeof _cache !== 'undefined') {
                if (_cache.has(Class)) return _cache.get(Class);

                _cache.set(Class, Wrapper);
            }

            function Wrapper() {
                return _construct(Class, arguments, _getPrototypeOf(this).constructor);
            }

            Wrapper.prototype = Object.create(Class.prototype, {
                constructor: {
                    value: Wrapper,
                    enumerable: false,
                    writable: true,
                    configurable: true
                }
            });
            return _setPrototypeOf(Wrapper, Class);
        };

        return _wrapNativeSuper(Class);
    }

    function _instanceof(left, right) {
        if (
            right != null &&
            typeof Symbol !== 'undefined' &&
            right[Symbol.hasInstance]
        ) {
            return right[Symbol.hasInstance](left);
        } else {
            return left instanceof right;
        }
    }

    function _interopRequireDefault(obj) {
        return obj && obj.__esModule
            ? obj
            : {
                default: obj
            };
    }

    function _interopRequireWildcard(obj) {
        if (obj && obj.__esModule) {
            return obj;
        } else {
            var newObj = {};

            if (obj != null) {
                for (var key in obj) {
                    if (Object.prototype.hasOwnProperty.call(obj, key)) {
                        var desc =
                            Object.defineProperty && Object.getOwnPropertyDescriptor
                                ? Object.getOwnPropertyDescriptor(obj, key)
                                : {};

                        if (desc.get || desc.set) {
                            Object.defineProperty(newObj, key, desc);
                        } else {
                            newObj[key] = obj[key];
                        }
                    }
                }
            }

            newObj.default = obj;
            return newObj;
        }
    }

    function _newArrowCheck(innerThis, boundThis) {
        if (innerThis !== boundThis) {
            throw new TypeError('Cannot instantiate an arrow function');
        }
    }

    function _objectDestructuringEmpty(obj) {
        if (obj == null) throw new TypeError('Cannot destructure undefined');
    }

    function _objectWithoutPropertiesLoose(source, excluded) {
        if (source == null) return {};
        var target = {};
        var sourceKeys = Object.keys(source);
        var key, i;

        for (i = 0; i < sourceKeys.length; i++) {
            key = sourceKeys[i];
            if (excluded.indexOf(key) >= 0) continue;
            target[key] = source[key];
        }

        return target;
    }

    function _objectWithoutProperties(source, excluded) {
        if (source == null) return {};

        var target = _objectWithoutPropertiesLoose(source, excluded);

        var key, i;

        if (Object.getOwnPropertySymbols) {
            var sourceSymbolKeys = Object.getOwnPropertySymbols(source);

            for (i = 0; i < sourceSymbolKeys.length; i++) {
                key = sourceSymbolKeys[i];
                if (excluded.indexOf(key) >= 0) continue;
                if (!Object.prototype.propertyIsEnumerable.call(source, key)) continue;
                target[key] = source[key];
            }
        }

        return target;
    }

    function _assertThisInitialized(self) {
        if (self === void 0) {
            throw new ReferenceError(
                "this hasn't been initialised - super() hasn't been called"
            );
        }

        return self;
    }

    function _possibleConstructorReturn(self, call) {
        if (call && (typeof call === 'object' || typeof call === 'function')) {
            return call;
        }

        return _assertThisInitialized(self);
    }

    function _superPropBase(object, property) {
        while (!Object.prototype.hasOwnProperty.call(object, property)) {
            object = _getPrototypeOf(object);
            if (object === null) break;
        }

        return object;
    }

    function _get(target, property, receiver) {
        if (typeof Reflect !== 'undefined' && Reflect.get) {
            _get = Reflect.get;
        } else {
            _get = function _get(target, property, receiver) {
                var base = _superPropBase(target, property);

                if (!base) return;
                var desc = Object.getOwnPropertyDescriptor(base, property);

                if (desc.get) {
                    return desc.get.call(receiver);
                }

                return desc.value;
            };
        }

        return _get(target, property, receiver || target);
    }

    function set(target, property, value, receiver) {
        if (typeof Reflect !== 'undefined' && Reflect.set) {
            set = Reflect.set;
        } else {
            set = function set(target, property, value, receiver) {
                var base = _superPropBase(target, property);

                var desc;

                if (base) {
                    desc = Object.getOwnPropertyDescriptor(base, property);

                    if (desc.set) {
                        desc.set.call(receiver, value);
                        return true;
                    } else if (!desc.writable) {
                        return false;
                    }
                }

                desc = Object.getOwnPropertyDescriptor(receiver, property);

                if (desc) {
                    if (!desc.writable) {
                        return false;
                    }

                    desc.value = value;
                    Object.defineProperty(receiver, property, desc);
                } else {
                    _defineProperty(receiver, property, value);
                }

                return true;
            };
        }

        return set(target, property, value, receiver);
    }

    function _set(target, property, value, receiver, isStrict) {
        var s = set(target, property, value, receiver || target);

        if (!s && isStrict) {
            throw new Error('failed to set property');
        }

        return value;
    }

    function _taggedTemplateLiteral(strings, raw) {
        if (!raw) {
            raw = strings.slice(0);
        }

        return Object.freeze(
            Object.defineProperties(strings, {
                raw: {
                    value: Object.freeze(raw)
                }
            })
        );
    }

    function _taggedTemplateLiteralLoose(strings, raw) {
        if (!raw) {
            raw = strings.slice(0);
        }

        strings.raw = raw;
        return strings;
    }

    function _temporalRef(val, name) {
        if (val === _temporalUndefined) {
            throw new ReferenceError(name + ' is not defined - temporal dead zone');
        } else {
            return val;
        }
    }

    function _readOnlyError(name) {
        throw new Error('"' + name + '" is read-only');
    }

    function _classNameTDZError(name) {
        throw new Error(
            'Class "' + name + '" cannot be referenced in computed property keys.'
        );
    }

    var _temporalUndefined = {};

    function _slicedToArray(arr, i) {
        return (
            _arrayWithHoles(arr) ||
            _iterableToArrayLimit(arr, i) ||
            _nonIterableRest()
        );
    }

    function _slicedToArrayLoose(arr, i) {
        return (
            _arrayWithHoles(arr) ||
            _iterableToArrayLimitLoose(arr, i) ||
            _nonIterableRest()
        );
    }

    function _toArray(arr) {
        return _arrayWithHoles(arr) || _iterableToArray(arr) || _nonIterableRest();
    }

    function _toConsumableArray(arr) {
        return (
            _arrayWithoutHoles(arr) || _iterableToArray(arr) || _nonIterableSpread()
        );
    }

    function _arrayWithoutHoles(arr) {
        if (Array.isArray(arr)) {
            for (var i = 0, arr2 = new Array(arr.length); i < arr.length; i++)
                arr2[i] = arr[i];

            return arr2;
        }
    }

    function _arrayWithHoles(arr) {
        if (Array.isArray(arr)) return arr;
    }

    function _iterableToArray(iter) {
        if (
            Symbol.iterator in Object(iter) ||
            Object.prototype.toString.call(iter) === '[object Arguments]'
        )
            return Array.from(iter);
    }

    function _iterableToArrayLimit(arr, i) {
        var _arr = [];
        var _n = true;
        var _d = false;
        var _e = undefined;

        try {
            for (
                var _i = arr[Symbol.iterator](), _s;
                !(_n = (_s = _i.next()).done);
                _n = true
            ) {
                _arr.push(_s.value);

                if (i && _arr.length === i) break;
            }
        } catch (err) {
            _d = true;
            _e = err;
        } finally {
            try {
                if (!_n && _i['return'] != null) _i['return']();
            } finally {
                if (_d) throw _e;
            }
        }

        return _arr;
    }

    function _iterableToArrayLimitLoose(arr, i) {
        var _arr = [];

        for (
            var _iterator = arr[Symbol.iterator](), _step;
            !(_step = _iterator.next()).done;

        ) {
            _arr.push(_step.value);

            if (i && _arr.length === i) break;
        }

        return _arr;
    }

    function _nonIterableSpread() {
        throw new TypeError('Invalid attempt to spread non-iterable instance');
    }

    function _nonIterableRest() {
        throw new TypeError('Invalid attempt to destructure non-iterable instance');
    }

    function _skipFirstGeneratorNext(fn) {
        return function() {
            var it = fn.apply(this, arguments);
            it.next();
            return it;
        };
    }

    function _toPrimitive(input, hint) {
        if (typeof input !== 'object' || input === null) return input;
        var prim = input[Symbol.toPrimitive];

        if (prim !== undefined) {
            var res = prim.call(input, hint || 'default');
            if (typeof res !== 'object') return res;
            throw new TypeError('@@toPrimitive must return a primitive value.');
        }

        return (hint === 'string' ? String : Number)(input);
    }

    function _toPropertyKey(arg) {
        var key = _toPrimitive(arg, 'string');

        return typeof key === 'symbol' ? key : String(key);
    }

    function _initializerWarningHelper(descriptor, context) {
        throw new Error(
            'Decorating class property failed. Please ensure that ' +
            'proposal-class-properties is enabled and set to use loose mode. ' +
            'To use proposal-class-properties in spec mode with decorators, wait for ' +
            'the next major version of decorators in stage 2.'
        );
    }

    function _initializerDefineProperty(target, property, descriptor, context) {
        if (!descriptor) return;
        Object.defineProperty(target, property, {
            enumerable: descriptor.enumerable,
            configurable: descriptor.configurable,
            writable: descriptor.writable,
            value: descriptor.initializer
                ? descriptor.initializer.call(context)
                : void 0
        });
    }

    function _applyDecoratedDescriptor(
        target,
        property,
        decorators,
        descriptor,
        context
    ) {
        var desc = {};
        Object.keys(descriptor).forEach(function(key) {
            desc[key] = descriptor[key];
        });
        desc.enumerable = !!desc.enumerable;
        desc.configurable = !!desc.configurable;

        if ('value' in desc || desc.initializer) {
            desc.writable = true;
        }

        desc = decorators
            .slice()
            .reverse()
            .reduce(function(desc, decorator) {
                return decorator(target, property, desc) || desc;
            }, desc);

        if (context && desc.initializer !== void 0) {
            desc.value = desc.initializer ? desc.initializer.call(context) : void 0;
            desc.initializer = undefined;
        }

        if (desc.initializer === void 0) {
            Object.defineProperty(target, property, desc);
            desc = null;
        }

        return desc;
    }

    var id = 0;

    function _classPrivateFieldLooseKey(name) {
        return '__private_' + id++ + '_' + name;
    }

    function _classPrivateFieldLooseBase(receiver, privateKey) {
        if (!Object.prototype.hasOwnProperty.call(receiver, privateKey)) {
            throw new TypeError('attempted to use private field on non-instance');
        }

        return receiver;
    }

    function _classPrivateFieldGet(receiver, privateMap) {
        if (!privateMap.has(receiver)) {
            throw new TypeError('attempted to get private field on non-instance');
        }

        var descriptor = privateMap.get(receiver);

        if (descriptor.get) {
            return descriptor.get.call(receiver);
        }

        return descriptor.value;
    }

    function _classPrivateFieldSet(receiver, privateMap, value) {
        if (!privateMap.has(receiver)) {
            throw new TypeError('attempted to set private field on non-instance');
        }

        var descriptor = privateMap.get(receiver);

        if (descriptor.set) {
            descriptor.set.call(receiver, value);
        } else {
            if (!descriptor.writable) {
                throw new TypeError('attempted to set read only private field');
            }

            descriptor.value = value;
        }

        return value;
    }

    function _classStaticPrivateFieldSpecGet(
        receiver,
        classConstructor,
        descriptor
    ) {
        if (receiver !== classConstructor) {
            throw new TypeError('Private static access of wrong provenance');
        }

        return descriptor.value;
    }

    function _classStaticPrivateFieldSpecSet(
        receiver,
        classConstructor,
        descriptor,
        value
    ) {
        if (receiver !== classConstructor) {
            throw new TypeError('Private static access of wrong provenance');
        }

        if (!descriptor.writable) {
            throw new TypeError('attempted to set read only private field');
        }

        descriptor.value = value;
        return value;
    }

    function _classStaticPrivateMethodGet(receiver, classConstructor, method) {
        if (receiver !== classConstructor) {
            throw new TypeError('Private static access of wrong provenance');
        }

        return method;
    }

    function _classStaticPrivateMethodSet() {
        throw new TypeError('attempted to set read only static private field');
    }

    function _decorate(decorators, factory, superClass, mixins) {
        var api = _getDecoratorsApi();

        if (mixins) {
            for (var i = 0; i < mixins.length; i++) {
                api = mixins[i](api);
            }
        }

        var r = factory(function initialize(O) {
            api.initializeInstanceElements(O, decorated.elements);
        }, superClass);
        var decorated = api.decorateClass(
            _coalesceClassElements(r.d.map(_createElementDescriptor)),
            decorators
        );
        api.initializeClassElements(r.F, decorated.elements);
        return api.runClassFinishers(r.F, decorated.finishers);
    }

    function _getDecoratorsApi() {
        _getDecoratorsApi = function() {
            return api;
        };

        var api = {
            elementsDefinitionOrder: [['method'], ['field']],
            initializeInstanceElements: function(O, elements) {
                ['method', 'field'].forEach(function(kind) {
                    elements.forEach(function(element) {
                        if (element.kind === kind && element.placement === 'own') {
                            this.defineClassElement(O, element);
                        }
                    }, this);
                }, this);
            },
            initializeClassElements: function(F, elements) {
                var proto = F.prototype;
                ['method', 'field'].forEach(function(kind) {
                    elements.forEach(function(element) {
                        var placement = element.placement;

                        if (
                            element.kind === kind &&
                            (placement === 'static' || placement === 'prototype')
                        ) {
                            var receiver = placement === 'static' ? F : proto;
                            this.defineClassElement(receiver, element);
                        }
                    }, this);
                }, this);
            },
            defineClassElement: function(receiver, element) {
                var descriptor = element.descriptor;

                if (element.kind === 'field') {
                    var initializer = element.initializer;
                    descriptor = {
                        enumerable: descriptor.enumerable,
                        writable: descriptor.writable,
                        configurable: descriptor.configurable,
                        value: initializer === void 0 ? void 0 : initializer.call(receiver)
                    };
                }

                Object.defineProperty(receiver, element.key, descriptor);
            },
            decorateClass: function(elements, decorators) {
                var newElements = [];
                var finishers = [];
                var placements = {
                    static: [],
                    prototype: [],
                    own: []
                };
                elements.forEach(function(element) {
                    this.addElementPlacement(element, placements);
                }, this);
                elements.forEach(function(element) {
                    if (!_hasDecorators(element)) return newElements.push(element);
                    var elementFinishersExtras = this.decorateElement(
                        element,
                        placements
                    );
                    newElements.push(elementFinishersExtras.element);
                    newElements.push.apply(newElements, elementFinishersExtras.extras);
                    finishers.push.apply(finishers, elementFinishersExtras.finishers);
                }, this);

                if (!decorators) {
                    return {
                        elements: newElements,
                        finishers: finishers
                    };
                }

                var result = this.decorateConstructor(newElements, decorators);
                finishers.push.apply(finishers, result.finishers);
                result.finishers = finishers;
                return result;
            },
            addElementPlacement: function(element, placements, silent) {
                var keys = placements[element.placement];

                if (!silent && keys.indexOf(element.key) !== -1) {
                    throw new TypeError('Duplicated element (' + element.key + ')');
                }

                keys.push(element.key);
            },
            decorateElement: function(element, placements) {
                var extras = [];
                var finishers = [];

                for (
                    var decorators = element.decorators, i = decorators.length - 1;
                    i >= 0;
                    i--
                ) {
                    var keys = placements[element.placement];
                    keys.splice(keys.indexOf(element.key), 1);
                    var elementObject = this.fromElementDescriptor(element);
                    var elementFinisherExtras = this.toElementFinisherExtras(
                        (0, decorators[i])(elementObject) || elementObject
                    );
                    element = elementFinisherExtras.element;
                    this.addElementPlacement(element, placements);

                    if (elementFinisherExtras.finisher) {
                        finishers.push(elementFinisherExtras.finisher);
                    }

                    var newExtras = elementFinisherExtras.extras;

                    if (newExtras) {
                        for (var j = 0; j < newExtras.length; j++) {
                            this.addElementPlacement(newExtras[j], placements);
                        }

                        extras.push.apply(extras, newExtras);
                    }
                }

                return {
                    element: element,
                    finishers: finishers,
                    extras: extras
                };
            },
            decorateConstructor: function(elements, decorators) {
                var finishers = [];

                for (var i = decorators.length - 1; i >= 0; i--) {
                    var obj = this.fromClassDescriptor(elements);
                    var elementsAndFinisher = this.toClassDescriptor(
                        (0, decorators[i])(obj) || obj
                    );

                    if (elementsAndFinisher.finisher !== undefined) {
                        finishers.push(elementsAndFinisher.finisher);
                    }

                    if (elementsAndFinisher.elements !== undefined) {
                        elements = elementsAndFinisher.elements;

                        for (var j = 0; j < elements.length - 1; j++) {
                            for (var k = j + 1; k < elements.length; k++) {
                                if (
                                    elements[j].key === elements[k].key &&
                                    elements[j].placement === elements[k].placement
                                ) {
                                    throw new TypeError(
                                        'Duplicated element (' + elements[j].key + ')'
                                    );
                                }
                            }
                        }
                    }
                }

                return {
                    elements: elements,
                    finishers: finishers
                };
            },
            fromElementDescriptor: function(element) {
                var obj = {
                    kind: element.kind,
                    key: element.key,
                    placement: element.placement,
                    descriptor: element.descriptor
                };
                var desc = {
                    value: 'Descriptor',
                    configurable: true
                };
                Object.defineProperty(obj, Symbol.toStringTag, desc);
                if (element.kind === 'field') obj.initializer = element.initializer;
                return obj;
            },
            toElementDescriptors: function(elementObjects) {
                if (elementObjects === undefined) return;
                return _toArray(elementObjects).map(function(elementObject) {
                    var element = this.toElementDescriptor(elementObject);
                    this.disallowProperty(
                        elementObject,
                        'finisher',
                        'An element descriptor'
                    );
                    this.disallowProperty(
                        elementObject,
                        'extras',
                        'An element descriptor'
                    );
                    return element;
                }, this);
            },
            toElementDescriptor: function(elementObject) {
                var kind = String(elementObject.kind);

                if (kind !== 'method' && kind !== 'field') {
                    throw new TypeError(
                        'An element descriptor\'s .kind property must be either "method" or' +
                        ' "field", but a decorator created an element descriptor with' +
                        ' .kind "' +
                        kind +
                        '"'
                    );
                }

                var key = _toPropertyKey(elementObject.key);

                var placement = String(elementObject.placement);

                if (
                    placement !== 'static' &&
                    placement !== 'prototype' &&
                    placement !== 'own'
                ) {
                    throw new TypeError(
                        'An element descriptor\'s .placement property must be one of "static",' +
                        ' "prototype" or "own", but a decorator created an element descriptor' +
                        ' with .placement "' +
                        placement +
                        '"'
                    );
                }

                var descriptor = elementObject.descriptor;
                this.disallowProperty(
                    elementObject,
                    'elements',
                    'An element descriptor'
                );
                var element = {
                    kind: kind,
                    key: key,
                    placement: placement,
                    descriptor: Object.assign({}, descriptor)
                };

                if (kind !== 'field') {
                    this.disallowProperty(
                        elementObject,
                        'initializer',
                        'A method descriptor'
                    );
                } else {
                    this.disallowProperty(
                        descriptor,
                        'get',
                        'The property descriptor of a field descriptor'
                    );
                    this.disallowProperty(
                        descriptor,
                        'set',
                        'The property descriptor of a field descriptor'
                    );
                    this.disallowProperty(
                        descriptor,
                        'value',
                        'The property descriptor of a field descriptor'
                    );
                    element.initializer = elementObject.initializer;
                }

                return element;
            },
            toElementFinisherExtras: function(elementObject) {
                var element = this.toElementDescriptor(elementObject);

                var finisher = _optionalCallableProperty(elementObject, 'finisher');

                var extras = this.toElementDescriptors(elementObject.extras);
                return {
                    element: element,
                    finisher: finisher,
                    extras: extras
                };
            },
            fromClassDescriptor: function(elements) {
                var obj = {
                    kind: 'class',
                    elements: elements.map(this.fromElementDescriptor, this)
                };
                var desc = {
                    value: 'Descriptor',
                    configurable: true
                };
                Object.defineProperty(obj, Symbol.toStringTag, desc);
                return obj;
            },
            toClassDescriptor: function(obj) {
                var kind = String(obj.kind);

                if (kind !== 'class') {
                    throw new TypeError(
                        'A class descriptor\'s .kind property must be "class", but a decorator' +
                        ' created a class descriptor with .kind "' +
                        kind +
                        '"'
                    );
                }

                this.disallowProperty(obj, 'key', 'A class descriptor');
                this.disallowProperty(obj, 'placement', 'A class descriptor');
                this.disallowProperty(obj, 'descriptor', 'A class descriptor');
                this.disallowProperty(obj, 'initializer', 'A class descriptor');
                this.disallowProperty(obj, 'extras', 'A class descriptor');

                var finisher = _optionalCallableProperty(obj, 'finisher');

                var elements = this.toElementDescriptors(obj.elements);
                return {
                    elements: elements,
                    finisher: finisher
                };
            },
            runClassFinishers: function(constructor, finishers) {
                for (var i = 0; i < finishers.length; i++) {
                    var newConstructor = (0, finishers[i])(constructor);

                    if (newConstructor !== undefined) {
                        if (typeof newConstructor !== 'function') {
                            throw new TypeError('Finishers must return a constructor.');
                        }

                        constructor = newConstructor;
                    }
                }

                return constructor;
            },
            disallowProperty: function(obj, name, objectType) {
                if (obj[name] !== undefined) {
                    throw new TypeError(
                        objectType + " can't have a ." + name + ' property.'
                    );
                }
            }
        };
        return api;
    }

    function _createElementDescriptor(def) {
        var key = _toPropertyKey(def.key);

        var descriptor;

        if (def.kind === 'method') {
            descriptor = {
                value: def.value,
                writable: true,
                configurable: true,
                enumerable: false
            };
        } else if (def.kind === 'get') {
            descriptor = {
                get: def.value,
                configurable: true,
                enumerable: false
            };
        } else if (def.kind === 'set') {
            descriptor = {
                set: def.value,
                configurable: true,
                enumerable: false
            };
        } else if (def.kind === 'field') {
            descriptor = {
                configurable: true,
                writable: true,
                enumerable: true
            };
        }

        var element = {
            kind: def.kind === 'field' ? 'field' : 'method',
            key: key,
            placement: def.static
                ? 'static'
                : def.kind === 'field'
                    ? 'own'
                    : 'prototype',
            descriptor: descriptor
        };
        if (def.decorators) element.decorators = def.decorators;
        if (def.kind === 'field') element.initializer = def.value;
        return element;
    }

    function _coalesceGetterSetter(element, other) {
        if (element.descriptor.get !== undefined) {
            other.descriptor.get = element.descriptor.get;
        } else {
            other.descriptor.set = element.descriptor.set;
        }
    }

    function _coalesceClassElements(elements) {
        var newElements = [];

        var isSameElement = function(other) {
            return (
                other.kind === 'method' &&
                other.key === element.key &&
                other.placement === element.placement
            );
        };

        for (var i = 0; i < elements.length; i++) {
            var element = elements[i];
            var other;

            if (
                element.kind === 'method' &&
                (other = newElements.find(isSameElement))
            ) {
                if (
                    _isDataDescriptor(element.descriptor) ||
                    _isDataDescriptor(other.descriptor)
                ) {
                    if (_hasDecorators(element) || _hasDecorators(other)) {
                        throw new ReferenceError(
                            'Duplicated methods (' + element.key + ") can't be decorated."
                        );
                    }

                    other.descriptor = element.descriptor;
                } else {
                    if (_hasDecorators(element)) {
                        if (_hasDecorators(other)) {
                            throw new ReferenceError(
                                "Decorators can't be placed on different accessors with for " +
                                'the same property (' +
                                element.key +
                                ').'
                            );
                        }

                        other.decorators = element.decorators;
                    }

                    _coalesceGetterSetter(element, other);
                }
            } else {
                newElements.push(element);
            }
        }

        return newElements;
    }

    function _hasDecorators(element) {
        return element.decorators && element.decorators.length;
    }

    function _isDataDescriptor(desc) {
        return (
            desc !== undefined &&
            !(desc.value === undefined && desc.writable === undefined)
        );
    }

    function _optionalCallableProperty(obj, name) {
        var value = obj[name];

        if (value !== undefined && typeof value !== 'function') {
            throw new TypeError("Expected '" + name + "' to be a function");
        }

        return value;
    }

    function _classPrivateMethodGet(receiver, privateSet, fn) {
        if (!privateSet.has(receiver)) {
            throw new TypeError('attempted to get private field on non-instance');
        }

        return fn;
    }

    function _classPrivateMethodSet() {
        throw new TypeError('attempted to reassign private method');
    }

    function _wrapRegExp(re, groups) {
        _wrapRegExp = function(re, groups) {
            return new BabelRegExp(re, groups);
        };

        var _RegExp = _wrapNativeSuper(RegExp);

        var _super = RegExp.prototype;

        var _groups = new WeakMap();

        function BabelRegExp(re, groups) {
            var _this = _RegExp.call(this, re);

            _groups.set(_this, groups);

            return _this;
        }

        _inherits(BabelRegExp, _RegExp);

        BabelRegExp.prototype.exec = function(str) {
            var result = _super.exec.call(this, str);

            if (result) result.groups = buildGroups(result, this);
            return result;
        };

        BabelRegExp.prototype[Symbol.replace] = function(str, substitution) {
            if (typeof substitution === 'string') {
                var groups = _groups.get(this);

                return _super[Symbol.replace].call(
                    this,
                    str,
                    substitution.replace(/\$<([^>]+)>/g, function(_, name) {
                        return '$' + groups[name];
                    })
                );
            } else if (typeof substitution === 'function') {
                var _this = this;

                return _super[Symbol.replace].call(this, str, function() {
                    var args = [];
                    args.push.apply(args, arguments);

                    if (typeof args[args.length - 1] !== 'object') {
                        args.push(buildGroups(args, _this));
                    }

                    return substitution.apply(this, args);
                });
            } else {
                return _super[Symbol.replace].call(this, str, substitution);
            }
        };

        function buildGroups(result, re) {
            var g = _groups.get(re);

            return Object.keys(g).reduce(function(groups, name) {
                groups[name] = result[g[name]];
                return groups;
            }, Object.create(null));
        }

        return _wrapRegExp.apply(this, arguments);
    }

    var vectorMultiply = function vectorMultiply(v, amount) {
        return createVector(v.x * amount, v.y * amount);
    };

    var vectorAdd = function vectorAdd(a, b) {
        return createVector(a.x + b.x, a.y + b.y);
    };

    var vectorNormalize = function vectorNormalize(v) {
        var l = Math.sqrt(v.x * v.x + v.y * v.y);
        if (l === 0) {
            return {
                x: 0,
                y: 0
            };
        }
        return createVector(v.x / l, v.y / l);
    };

    var vectorRotate = function vectorRotate(v, radians, origin) {
        var cos = Math.cos(radians);
        var sin = Math.sin(radians);
        var t = createVector(v.x - origin.x, v.y - origin.y);
        return createVector(
            origin.x + cos * t.x - sin * t.y,
            origin.y + sin * t.x + cos * t.y
        );
    };

    var createVector = function createVector() {
        var x =
            arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 0;
        var y =
            arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 0;
        return { x: x, y: y };
    };

    var getMarkupValue = function getMarkupValue(value, size) {
        var scalar =
            arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 1;
        var axis = arguments.length > 3 ? arguments[3] : undefined;
        if (typeof value === 'string') {
            return parseFloat(value) * scalar;
        }
        if (typeof value === 'number') {
            return value * (axis ? size[axis] : Math.min(size.width, size.height));
        }
        return;
    };

    var getMarkupStyles = function getMarkupStyles(markup, size, scale) {
        var lineStyle = markup.borderStyle || markup.lineStyle || 'solid';
        var fill = markup.backgroundColor || markup.fontColor || 'transparent';
        var stroke = markup.borderColor || markup.lineColor || 'transparent';
        var strokeWidth = getMarkupValue(
            markup.borderWidth || markup.lineWidth,
            size,
            scale
        );
        var lineCap = markup.lineCap || 'round';
        var lineJoin = markup.lineJoin || 'round';
        var dashes =
            typeof lineStyle === 'string'
                ? ''
                : lineStyle
                    .map(function(v) {
                        return getMarkupValue(v, size, scale);
                    })
                    .join(',');
        var opacity = markup.opacity || 1;
        return {
            'stroke-linecap': lineCap,
            'stroke-linejoin': lineJoin,
            'stroke-width': strokeWidth || 0,
            'stroke-dasharray': dashes,
            stroke: stroke,
            fill: fill,
            opacity: opacity
        };
    };

    var isDefined = function isDefined(value) {
        return value != null;
    };

    var getMarkupRect = function getMarkupRect(rect, size) {
        var scalar =
            arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 1;

        var left =
            getMarkupValue(rect.x, size, scalar, 'width') ||
            getMarkupValue(rect.left, size, scalar, 'width');
        var top =
            getMarkupValue(rect.y, size, scalar, 'height') ||
            getMarkupValue(rect.top, size, scalar, 'height');
        var width = getMarkupValue(rect.width, size, scalar, 'width');
        var height = getMarkupValue(rect.height, size, scalar, 'height');
        var right = getMarkupValue(rect.right, size, scalar, 'width');
        var bottom = getMarkupValue(rect.bottom, size, scalar, 'height');

        if (!isDefined(top)) {
            if (isDefined(height) && isDefined(bottom)) {
                top = size.height - height - bottom;
            } else {
                top = bottom;
            }
        }

        if (!isDefined(left)) {
            if (isDefined(width) && isDefined(right)) {
                left = size.width - width - right;
            } else {
                left = right;
            }
        }

        if (!isDefined(width)) {
            if (isDefined(left) && isDefined(right)) {
                width = size.width - left - right;
            } else {
                width = 0;
            }
        }

        if (!isDefined(height)) {
            if (isDefined(top) && isDefined(bottom)) {
                height = size.height - top - bottom;
            } else {
                height = 0;
            }
        }

        return {
            x: left || 0,
            y: top || 0,
            width: width || 0,
            height: height || 0
        };
    };

    var pointsToPathShape = function pointsToPathShape(points) {
        return points
            .map(function(point, index) {
                return ''
                    .concat(index === 0 ? 'M' : 'L', ' ')
                    .concat(point.x, ' ')
                    .concat(point.y);
            })
            .join(' ');
    };

    var setAttributes = function setAttributes(element, attr) {
        return Object.keys(attr).forEach(function(key) {
            return element.setAttribute(key, attr[key]);
        });
    };

    var ns = 'http://www.w3.org/2000/svg';
    var svg = function svg(tag, attr) {
        var element = document.createElementNS(ns, tag);
        if (attr) {
            setAttributes(element, attr);
        }
        return element;
    };

    var updateRect = function updateRect(element) {
        return setAttributes(
            element,
            Object.assign({}, element.rect, element.styles)
        );
    };

    var updateEllipse = function updateEllipse(element) {
        var cx = element.rect.x + element.rect.width * 0.5;
        var cy = element.rect.y + element.rect.height * 0.5;
        var rx = element.rect.width * 0.5;
        var ry = element.rect.height * 0.5;
        return setAttributes(
            element,
            Object.assign(
                {
                    cx: cx,
                    cy: cy,
                    rx: rx,
                    ry: ry
                },
                element.styles
            )
        );
    };

    var IMAGE_FIT_STYLE = {
        contain: 'xMidYMid meet',
        cover: 'xMidYMid slice'
    };

    var updateImage = function updateImage(element, markup) {
        setAttributes(
            element,
            Object.assign({}, element.rect, element.styles, {
                preserveAspectRatio: IMAGE_FIT_STYLE[markup.fit] || 'none'
            })
        );
    };

    var TEXT_ANCHOR = {
        left: 'start',
        center: 'middle',
        right: 'end'
    };

    var updateText = function updateText(element, markup, size, scale) {
        var fontSize = getMarkupValue(markup.fontSize, size, scale);
        var fontFamily = markup.fontFamily || 'sans-serif';
        var fontWeight = markup.fontWeight || 'normal';
        var textAlign = TEXT_ANCHOR[markup.textAlign] || 'start';

        setAttributes(
            element,
            Object.assign({}, element.rect, element.styles, {
                'stroke-width': 0,
                'font-weight': fontWeight,
                'font-size': fontSize,
                'font-family': fontFamily,
                'text-anchor': textAlign
            })
        );

        // update text
        if (element.text !== markup.text) {
            element.text = markup.text;
            element.textContent = markup.text.length ? markup.text : ' ';
        }
    };

    var updateLine = function updateLine(element, markup, size, scale) {
        setAttributes(
            element,
            Object.assign({}, element.rect, element.styles, {
                fill: 'none'
            })
        );

        var line = element.childNodes[0];
        var begin = element.childNodes[1];
        var end = element.childNodes[2];

        var origin = element.rect;

        var target = {
            x: element.rect.x + element.rect.width,
            y: element.rect.y + element.rect.height
        };

        setAttributes(line, {
            x1: origin.x,
            y1: origin.y,
            x2: target.x,
            y2: target.y
        });

        if (!markup.lineDecoration) return;

        begin.style.display = 'none';
        end.style.display = 'none';

        var v = vectorNormalize({
            x: target.x - origin.x,
            y: target.y - origin.y
        });

        var l = getMarkupValue(0.05, size, scale);

        if (markup.lineDecoration.indexOf('arrow-begin') !== -1) {
            var arrowBeginRotationPoint = vectorMultiply(v, l);
            var arrowBeginCenter = vectorAdd(origin, arrowBeginRotationPoint);
            var arrowBeginA = vectorRotate(origin, 2, arrowBeginCenter);
            var arrowBeginB = vectorRotate(origin, -2, arrowBeginCenter);

            setAttributes(begin, {
                style: 'display:block;',
                d: 'M'
                    .concat(arrowBeginA.x, ',')
                    .concat(arrowBeginA.y, ' L')
                    .concat(origin.x, ',')
                    .concat(origin.y, ' L')
                    .concat(arrowBeginB.x, ',')
                    .concat(arrowBeginB.y)
            });
        }

        if (markup.lineDecoration.indexOf('arrow-end') !== -1) {
            var arrowEndRotationPoint = vectorMultiply(v, -l);
            var arrowEndCenter = vectorAdd(target, arrowEndRotationPoint);
            var arrowEndA = vectorRotate(target, 2, arrowEndCenter);
            var arrowEndB = vectorRotate(target, -2, arrowEndCenter);

            setAttributes(end, {
                style: 'display:block;',
                d: 'M'
                    .concat(arrowEndA.x, ',')
                    .concat(arrowEndA.y, ' L')
                    .concat(target.x, ',')
                    .concat(target.y, ' L')
                    .concat(arrowEndB.x, ',')
                    .concat(arrowEndB.y)
            });
        }
    };

    var updatePath = function updatePath(element, markup, size, scale) {
        setAttributes(
            element,
            Object.assign({}, element.styles, {
                fill: 'none',
                d: pointsToPathShape(
                    markup.points.map(function(point) {
                        return {
                            x: getMarkupValue(point.x, size, scale, 'width'),
                            y: getMarkupValue(point.y, size, scale, 'height')
                        };
                    })
                )
            })
        );
    };

    var createShape = function createShape(node) {
        return function(markup) {
            return svg(node, { id: markup.id });
        };
    };

    var createImage = function createImage(markup) {
        var shape = svg('image', {
            id: markup.id,
            'stroke-linecap': 'round',
            'stroke-linejoin': 'round',
            opacity: '0'
        });

        shape.onload = function() {
            shape.setAttribute('opacity', markup.opacity || 1);
        };
        shape.setAttributeNS(
            'http://www.w3.org/1999/xlink',
            'xlink:href',
            markup.src
        );
        return shape;
    };

    var createLine = function createLine(markup) {
        var shape = svg('g', {
            id: markup.id,
            'stroke-linecap': 'round',
            'stroke-linejoin': 'round'
        });

        var line = svg('line');
        shape.appendChild(line);

        var begin = svg('path');
        shape.appendChild(begin);

        var end = svg('path');
        shape.appendChild(end);

        return shape;
    };

    var CREATE_TYPE_ROUTES = {
        image: createImage,
        rect: createShape('rect'),
        ellipse: createShape('ellipse'),
        text: createShape('text'),
        path: createShape('path'),
        line: createLine
    };

    var UPDATE_TYPE_ROUTES = {
        rect: updateRect,
        ellipse: updateEllipse,
        image: updateImage,
        text: updateText,
        path: updatePath,
        line: updateLine
    };

    var createMarkupByType = function createMarkupByType(type, markup) {
        return CREATE_TYPE_ROUTES[type](markup);
    };

    var updateMarkupByType = function updateMarkupByType(
        element,
        type,
        markup,
        size,
        scale
    ) {
        if (type !== 'path') {
            element.rect = getMarkupRect(markup, size, scale);
        }
        element.styles = getMarkupStyles(markup, size, scale);
        UPDATE_TYPE_ROUTES[type](element, markup, size, scale);
    };

    var MARKUP_RECT = [
        'x',
        'y',
        'left',
        'top',
        'right',
        'bottom',
        'width',
        'height'
    ];

    var toOptionalFraction = function toOptionalFraction(value) {
        return typeof value === 'string' && /%/.test(value)
            ? parseFloat(value) / 100
            : value;
    };

    // adds default markup properties, clones markup
    var prepareMarkup = function prepareMarkup(markup) {
        var _markup = _slicedToArray(markup, 2),
            type = _markup[0],
            props = _markup[1];

        var rect = props.points
            ? {}
            : MARKUP_RECT.reduce(function(prev, curr) {
                prev[curr] = toOptionalFraction(props[curr]);
                return prev;
            }, {});

        return [
            type,
            Object.assign(
                {
                    zIndex: 0
                },
                props,
                rect
            )
        ];
    };

    var sortMarkupByZIndex = function sortMarkupByZIndex(a, b) {
        if (a[1].zIndex > b[1].zIndex) {
            return 1;
        }
        if (a[1].zIndex < b[1].zIndex) {
            return -1;
        }
        return 0;
    };

    var createMarkupView = function createMarkupView(_) {
        return _.utils.createView({
            name: 'image-preview-markup',
            tag: 'svg',
            ignoreRect: true,
            mixins: {
                apis: ['width', 'height', 'crop', 'markup', 'resize', 'dirty']
            },

            write: function write(_ref) {
                var root = _ref.root,
                    props = _ref.props;

                if (!props.dirty) return;
                var crop = props.crop,
                    resize = props.resize,
                    markup = props.markup;

                var viewWidth = props.width;
                var viewHeight = props.height;

                var cropWidth = crop.width;
                var cropHeight = crop.height;

                if (resize) {
                    var _size = resize.size;

                    var outputWidth = _size && _size.width;
                    var outputHeight = _size && _size.height;
                    var outputFit = resize.mode;
                    var outputUpscale = resize.upscale;

                    if (outputWidth && !outputHeight) outputHeight = outputWidth;
                    if (outputHeight && !outputWidth) outputWidth = outputHeight;

                    var shouldUpscale =
                        cropWidth < outputWidth && cropHeight < outputHeight;

                    if (!shouldUpscale || (shouldUpscale && outputUpscale)) {
                        var scalarWidth = outputWidth / cropWidth;
                        var scalarHeight = outputHeight / cropHeight;

                        if (outputFit === 'force') {
                            cropWidth = outputWidth;
                            cropHeight = outputHeight;
                        } else {
                            var scalar;
                            if (outputFit === 'cover') {
                                scalar = Math.max(scalarWidth, scalarHeight);
                            } else if (outputFit === 'contain') {
                                scalar = Math.min(scalarWidth, scalarHeight);
                            }
                            cropWidth = cropWidth * scalar;
                            cropHeight = cropHeight * scalar;
                        }
                    }
                }

                var size = {
                    width: viewWidth,
                    height: viewHeight
                };

                root.element.setAttribute('width', size.width);
                root.element.setAttribute('height', size.height);

                var scale = Math.min(viewWidth / cropWidth, viewHeight / cropHeight);

                // clear
                root.element.innerHTML = '';

                // get filter
                var markupFilter = root.query('GET_IMAGE_PREVIEW_MARKUP_FILTER');

                // draw new
                markup
                    .filter(markupFilter)
                    .map(prepareMarkup)
                    .sort(sortMarkupByZIndex)
                    .forEach(function(markup) {
                        var _markup = _slicedToArray(markup, 2),
                            type = _markup[0],
                            settings = _markup[1];

                        // create
                        var element = createMarkupByType(type, settings);

                        // update
                        updateMarkupByType(element, type, settings, size, scale);

                        // add
                        root.element.appendChild(element);
                    });
            }
        });
    };

    var createVector$1 = function createVector(x, y) {
        return { x: x, y: y };
    };

    var vectorDot = function vectorDot(a, b) {
        return a.x * b.x + a.y * b.y;
    };

    var vectorSubtract = function vectorSubtract(a, b) {
        return createVector$1(a.x - b.x, a.y - b.y);
    };

    var vectorDistanceSquared = function vectorDistanceSquared(a, b) {
        return vectorDot(vectorSubtract(a, b), vectorSubtract(a, b));
    };

    var vectorDistance = function vectorDistance(a, b) {
        return Math.sqrt(vectorDistanceSquared(a, b));
    };

    var getOffsetPointOnEdge = function getOffsetPointOnEdge(length, rotation) {
        var a = length;

        var A = 1.5707963267948966;
        var B = rotation;
        var C = 1.5707963267948966 - rotation;

        var sinA = Math.sin(A);
        var sinB = Math.sin(B);
        var sinC = Math.sin(C);
        var cosC = Math.cos(C);
        var ratio = a / sinA;
        var b = ratio * sinB;
        var c = ratio * sinC;

        return createVector$1(cosC * b, cosC * c);
    };

    var getRotatedRectSize = function getRotatedRectSize(rect, rotation) {
        var w = rect.width;
        var h = rect.height;

        var hor = getOffsetPointOnEdge(w, rotation);
        var ver = getOffsetPointOnEdge(h, rotation);

        var tl = createVector$1(rect.x + Math.abs(hor.x), rect.y - Math.abs(hor.y));

        var tr = createVector$1(
            rect.x + rect.width + Math.abs(ver.y),
            rect.y + Math.abs(ver.x)
        );

        var bl = createVector$1(
            rect.x - Math.abs(ver.y),
            rect.y + rect.height - Math.abs(ver.x)
        );

        return {
            width: vectorDistance(tl, tr),
            height: vectorDistance(tl, bl)
        };
    };

    var calculateCanvasSize = function calculateCanvasSize(
        image,
        canvasAspectRatio
    ) {
        var zoom =
            arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 1;

        var imageAspectRatio = image.height / image.width;

        // determine actual pixels on x and y axis
        var canvasWidth = 1;
        var canvasHeight = canvasAspectRatio;
        var imgWidth = 1;
        var imgHeight = imageAspectRatio;
        if (imgHeight > canvasHeight) {
            imgHeight = canvasHeight;
            imgWidth = imgHeight / imageAspectRatio;
        }

        var scalar = Math.max(canvasWidth / imgWidth, canvasHeight / imgHeight);
        var width = image.width / (zoom * scalar * imgWidth);
        var height = width * canvasAspectRatio;

        return {
            width: width,
            height: height
        };
    };

    var getImageRectZoomFactor = function getImageRectZoomFactor(
        imageRect,
        cropRect,
        rotation,
        center
    ) {
        // calculate available space round image center position
        var cx = center.x > 0.5 ? 1 - center.x : center.x;
        var cy = center.y > 0.5 ? 1 - center.y : center.y;
        var imageWidth = cx * 2 * imageRect.width;
        var imageHeight = cy * 2 * imageRect.height;

        // calculate rotated crop rectangle size
        var rotatedCropSize = getRotatedRectSize(cropRect, rotation);

        // calculate scalar required to fit image
        return Math.max(
            rotatedCropSize.width / imageWidth,
            rotatedCropSize.height / imageHeight
        );
    };

    var getCenteredCropRect = function getCenteredCropRect(
        container,
        aspectRatio
    ) {
        var width = container.width;
        var height = width * aspectRatio;
        if (height > container.height) {
            height = container.height;
            width = height / aspectRatio;
        }
        var x = (container.width - width) * 0.5;
        var y = (container.height - height) * 0.5;

        return {
            x: x,
            y: y,
            width: width,
            height: height
        };
    };

    var getCurrentCropSize = function getCurrentCropSize(imageSize) {
        var crop =
            arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};
        var zoom = crop.zoom,
            rotation = crop.rotation,
            center = crop.center,
            aspectRatio = crop.aspectRatio;

        if (!aspectRatio) aspectRatio = imageSize.height / imageSize.width;

        var canvasSize = calculateCanvasSize(imageSize, aspectRatio, zoom);

        var canvasCenter = {
            x: canvasSize.width * 0.5,
            y: canvasSize.height * 0.5
        };

        var stage = {
            x: 0,
            y: 0,
            width: canvasSize.width,
            height: canvasSize.height,
            center: canvasCenter
        };

        var shouldLimit = typeof crop.scaleToFit === 'undefined' || crop.scaleToFit;

        var stageZoomFactor = getImageRectZoomFactor(
            imageSize,
            getCenteredCropRect(stage, aspectRatio),
            rotation,
            shouldLimit ? center : { x: 0.5, y: 0.5 }
        );

        var scale = zoom * stageZoomFactor;

        // start drawing
        return {
            widthFloat: canvasSize.width / scale,
            heightFloat: canvasSize.height / scale,
            width: Math.round(canvasSize.width / scale),
            height: Math.round(canvasSize.height / scale)
        };
    };

    var IMAGE_SCALE_SPRING_PROPS = {
        type: 'spring',
        stiffness: 0.5,
        damping: 0.45,
        mass: 10
    };

    // does horizontal and vertical flipping
    var createBitmapView = function createBitmapView(_) {
        return _.utils.createView({
            name: 'image-bitmap',
            ignoreRect: true,
            mixins: { styles: ['scaleX', 'scaleY'] },
            create: function create(_ref) {
                var root = _ref.root,
                    props = _ref.props;
                root.appendChild(props.image);
            }
        });
    };

    // shifts and rotates image
    var createImageCanvasWrapper = function createImageCanvasWrapper(_) {
        return _.utils.createView({
            name: 'image-canvas-wrapper',
            tag: 'div',
            ignoreRect: true,
            mixins: {
                apis: ['crop', 'width', 'height'],

                styles: [
                    'originX',
                    'originY',
                    'translateX',
                    'translateY',
                    'scaleX',
                    'scaleY',
                    'rotateZ'
                ],

                animations: {
                    originX: IMAGE_SCALE_SPRING_PROPS,
                    originY: IMAGE_SCALE_SPRING_PROPS,
                    scaleX: IMAGE_SCALE_SPRING_PROPS,
                    scaleY: IMAGE_SCALE_SPRING_PROPS,
                    translateX: IMAGE_SCALE_SPRING_PROPS,
                    translateY: IMAGE_SCALE_SPRING_PROPS,
                    rotateZ: IMAGE_SCALE_SPRING_PROPS
                }
            },

            create: function create(_ref2) {
                var root = _ref2.root,
                    props = _ref2.props;
                props.width = props.image.width;
                props.height = props.image.height;
                root.ref.bitmap = root.appendChildView(
                    root.createChildView(createBitmapView(_), { image: props.image })
                );
            },
            write: function write(_ref3) {
                var root = _ref3.root,
                    props = _ref3.props;
                var flip = props.crop.flip;
                var bitmap = root.ref.bitmap;
                bitmap.scaleX = flip.horizontal ? -1 : 1;
                bitmap.scaleY = flip.vertical ? -1 : 1;
            }
        });
    };

    // clips canvas to correct aspect ratio
    var createClipView = function createClipView(_) {
        return _.utils.createView({
            name: 'image-clip',
            tag: 'div',
            ignoreRect: true,
            mixins: {
                apis: [
                    'crop',
                    'markup',
                    'resize',
                    'width',
                    'height',
                    'dirty',
                    'background'
                ],

                styles: ['width', 'height', 'opacity'],
                animations: {
                    opacity: { type: 'tween', duration: 250 }
                }
            },

            didWriteView: function didWriteView(_ref4) {
                var root = _ref4.root,
                    props = _ref4.props;
                if (!props.background) return;
                root.element.style.backgroundColor = props.background;
            },
            create: function create(_ref5) {
                var root = _ref5.root,
                    props = _ref5.props;

                root.ref.image = root.appendChildView(
                    root.createChildView(
                        createImageCanvasWrapper(_),
                        Object.assign({}, props)
                    )
                );

                root.ref.createMarkup = function() {
                    if (root.ref.markup) return;
                    root.ref.markup = root.appendChildView(
                        root.createChildView(createMarkupView(_), Object.assign({}, props))
                    );
                };

                root.ref.destroyMarkup = function() {
                    if (!root.ref.markup) return;
                    root.removeChildView(root.ref.markup);
                    root.ref.markup = null;
                };

                // set up transparency grid
                var transparencyIndicator = root.query(
                    'GET_IMAGE_PREVIEW_TRANSPARENCY_INDICATOR'
                );
                if (transparencyIndicator === null) return;

                // grid pattern
                if (transparencyIndicator === 'grid') {
                    root.element.dataset.transparencyIndicator = transparencyIndicator;
                }
                // basic color
                else {
                    root.element.dataset.transparencyIndicator = 'color';
                }
            },
            write: function write(_ref6) {
                var root = _ref6.root,
                    props = _ref6.props,
                    shouldOptimize = _ref6.shouldOptimize;
                var crop = props.crop,
                    markup = props.markup,
                    resize = props.resize,
                    dirty = props.dirty,
                    width = props.width,
                    height = props.height;

                root.ref.image.crop = crop;

                var stage = {
                    x: 0,
                    y: 0,
                    width: width,
                    height: height,
                    center: {
                        x: width * 0.5,
                        y: height * 0.5
                    }
                };

                var image = {
                    width: root.ref.image.width,
                    height: root.ref.image.height
                };

                var origin = {
                    x: crop.center.x * image.width,
                    y: crop.center.y * image.height
                };

                var translation = {
                    x: stage.center.x - image.width * crop.center.x,
                    y: stage.center.y - image.height * crop.center.y
                };

                var rotation = Math.PI * 2 + (crop.rotation % (Math.PI * 2));

                var cropAspectRatio = crop.aspectRatio || image.height / image.width;

                var shouldLimit =
                    typeof crop.scaleToFit === 'undefined' || crop.scaleToFit;

                var stageZoomFactor = getImageRectZoomFactor(
                    image,
                    getCenteredCropRect(stage, cropAspectRatio),

                    rotation,
                    shouldLimit ? crop.center : { x: 0.5, y: 0.5 }
                );

                var scale = crop.zoom * stageZoomFactor;

                // update markup view
                if (markup && markup.length) {
                    root.ref.createMarkup();
                    root.ref.markup.width = width;
                    root.ref.markup.height = height;
                    root.ref.markup.resize = resize;
                    root.ref.markup.dirty = dirty;
                    root.ref.markup.markup = markup;
                    root.ref.markup.crop = getCurrentCropSize(image, crop);
                } else if (root.ref.markup) {
                    root.ref.destroyMarkup();
                }

                // update image view
                var imageView = root.ref.image;

                // don't update clip layout
                if (shouldOptimize) {
                    imageView.originX = null;
                    imageView.originY = null;
                    imageView.translateX = null;
                    imageView.translateY = null;
                    imageView.rotateZ = null;
                    imageView.scaleX = null;
                    imageView.scaleY = null;
                    return;
                }

                imageView.originX = origin.x;
                imageView.originY = origin.y;
                imageView.translateX = translation.x;
                imageView.translateY = translation.y;
                imageView.rotateZ = rotation;
                imageView.scaleX = scale;
                imageView.scaleY = scale;
            }
        });
    };

    var createImageView = function createImageView(_) {
        return _.utils.createView({
            name: 'image-preview',
            tag: 'div',
            ignoreRect: true,
            mixins: {
                apis: ['image', 'crop', 'markup', 'resize', 'dirty', 'background'],

                styles: ['translateY', 'scaleX', 'scaleY', 'opacity'],

                animations: {
                    scaleX: IMAGE_SCALE_SPRING_PROPS,
                    scaleY: IMAGE_SCALE_SPRING_PROPS,
                    translateY: IMAGE_SCALE_SPRING_PROPS,
                    opacity: { type: 'tween', duration: 400 }
                }
            },

            create: function create(_ref7) {
                var root = _ref7.root,
                    props = _ref7.props;
                root.ref.clip = root.appendChildView(
                    root.createChildView(createClipView(_), {
                        id: props.id,
                        image: props.image,
                        crop: props.crop,
                        markup: props.markup,
                        resize: props.resize,
                        dirty: props.dirty,
                        background: props.background
                    })
                );
            },
            write: function write(_ref8) {
                var root = _ref8.root,
                    props = _ref8.props,
                    shouldOptimize = _ref8.shouldOptimize;
                var clip = root.ref.clip;
                var image = props.image,
                    crop = props.crop,
                    markup = props.markup,
                    resize = props.resize,
                    dirty = props.dirty;

                clip.crop = crop;
                clip.markup = markup;
                clip.resize = resize;
                clip.dirty = dirty;

                // don't update clip layout
                clip.opacity = shouldOptimize ? 0 : 1;

                // don't re-render if optimizing or hidden (width will be zero resulting in weird animations)
                if (shouldOptimize || root.rect.element.hidden) return;

                // calculate scaled preview image size
                var imageAspectRatio = image.height / image.width;
                var aspectRatio = crop.aspectRatio || imageAspectRatio;

                // calculate container size
                var containerWidth = root.rect.inner.width;
                var containerHeight = root.rect.inner.height;

                var fixedPreviewHeight = root.query('GET_IMAGE_PREVIEW_HEIGHT');
                var minPreviewHeight = root.query('GET_IMAGE_PREVIEW_MIN_HEIGHT');
                var maxPreviewHeight = root.query('GET_IMAGE_PREVIEW_MAX_HEIGHT');

                var panelAspectRatio = root.query('GET_PANEL_ASPECT_RATIO');
                var allowMultiple = root.query('GET_ALLOW_MULTIPLE');

                if (panelAspectRatio && !allowMultiple) {
                    fixedPreviewHeight = containerWidth * panelAspectRatio;
                    aspectRatio = panelAspectRatio;
                }

                // determine clip width and height
                var clipHeight =
                    fixedPreviewHeight !== null
                        ? fixedPreviewHeight
                        : Math.max(
                            minPreviewHeight,
                            Math.min(containerWidth * aspectRatio, maxPreviewHeight)
                        );

                var clipWidth = clipHeight / aspectRatio;
                if (clipWidth > containerWidth) {
                    clipWidth = containerWidth;
                    clipHeight = clipWidth * aspectRatio;
                }

                if (clipHeight > containerHeight) {
                    clipHeight = containerHeight;
                    clipWidth = containerHeight / aspectRatio;
                }

                clip.width = clipWidth;
                clip.height = clipHeight;
            }
        });
    };

    var SVG_MASK =
        '<svg width="500" height="200" viewBox="0 0 500 200" preserveAspectRatio="none">\n    <defs>\n        <radialGradient id="gradient-__UID__" cx=".5" cy="1.25" r="1.15">\n            <stop offset=\'50%\' stop-color=\'#000000\'/>\n            <stop offset=\'56%\' stop-color=\'#0a0a0a\'/>\n            <stop offset=\'63%\' stop-color=\'#262626\'/>\n            <stop offset=\'69%\' stop-color=\'#4f4f4f\'/>\n            <stop offset=\'75%\' stop-color=\'#808080\'/>\n            <stop offset=\'81%\' stop-color=\'#b1b1b1\'/>\n            <stop offset=\'88%\' stop-color=\'#dadada\'/>\n            <stop offset=\'94%\' stop-color=\'#f6f6f6\'/>\n            <stop offset=\'100%\' stop-color=\'#ffffff\'/>\n        </radialGradient>\n        <mask id="mask-__UID__">\n            <rect x="0" y="0" width="500" height="200" fill="url(#gradient-__UID__)"></rect>\n        </mask>\n    </defs>\n    <rect x="0" width="500" height="200" fill="currentColor" mask="url(#mask-__UID__)"></rect>\n</svg>';

    var SVGMaskUniqueId = 0;

    var createImageOverlayView = function createImageOverlayView(fpAPI) {
        return fpAPI.utils.createView({
            name: 'image-preview-overlay',
            tag: 'div',
            ignoreRect: true,
            create: function create(_ref) {
                var root = _ref.root,
                    props = _ref.props;
                var mask = SVG_MASK;
                if (document.querySelector('base')) {
                    var url = new URL(
                        window.location.href.replace(window.location.hash, '')
                    ).href;
                    mask = mask.replace(/url\(\#/g, 'url(' + url + '#');
                }

                SVGMaskUniqueId++;
                root.element.classList.add(
                    'filepond--image-preview-overlay-'.concat(props.status)
                );

                root.element.innerHTML = mask.replace(/__UID__/g, SVGMaskUniqueId);
            },
            mixins: {
                styles: ['opacity'],
                animations: {
                    opacity: { type: 'spring', mass: 25 }
                }
            }
        });
    };

    /**
     * Bitmap Worker
     */
    var BitmapWorker = function BitmapWorker() {
        self.onmessage = function(e) {
            createImageBitmap(e.data.message.file).then(function(bitmap) {
                self.postMessage({ id: e.data.id, message: bitmap }, [bitmap]);
            });
        };
    };

    /**
     * ColorMatrix Worker
     */
    var ColorMatrixWorker = function ColorMatrixWorker() {
        self.onmessage = function(e) {
            var imageData = e.data.message.imageData;
            var matrix = e.data.message.colorMatrix;

            var data = imageData.data;
            var l = data.length;

            var m11 = matrix[0];
            var m12 = matrix[1];
            var m13 = matrix[2];
            var m14 = matrix[3];
            var m15 = matrix[4];

            var m21 = matrix[5];
            var m22 = matrix[6];
            var m23 = matrix[7];
            var m24 = matrix[8];
            var m25 = matrix[9];

            var m31 = matrix[10];
            var m32 = matrix[11];
            var m33 = matrix[12];
            var m34 = matrix[13];
            var m35 = matrix[14];

            var m41 = matrix[15];
            var m42 = matrix[16];
            var m43 = matrix[17];
            var m44 = matrix[18];
            var m45 = matrix[19];

            var index = 0,
                r = 0.0,
                g = 0.0,
                b = 0.0,
                a = 0.0;

            for (; index < l; index += 4) {
                r = data[index] / 255;
                g = data[index + 1] / 255;
                b = data[index + 2] / 255;
                a = data[index + 3] / 255;
                data[index] = Math.max(
                    0,
                    Math.min((r * m11 + g * m12 + b * m13 + a * m14 + m15) * 255, 255)
                );
                data[index + 1] = Math.max(
                    0,
                    Math.min((r * m21 + g * m22 + b * m23 + a * m24 + m25) * 255, 255)
                );
                data[index + 2] = Math.max(
                    0,
                    Math.min((r * m31 + g * m32 + b * m33 + a * m34 + m35) * 255, 255)
                );
                data[index + 3] = Math.max(
                    0,
                    Math.min((r * m41 + g * m42 + b * m43 + a * m44 + m45) * 255, 255)
                );
            }

            self.postMessage({ id: e.data.id, message: imageData }, [
                imageData.data.buffer
            ]);
        };
    };

    var getImageSize = function getImageSize(url, cb) {
        var image = new Image();
        image.onload = function() {
            var width = image.naturalWidth;
            var height = image.naturalHeight;
            image = null;
            cb(width, height);
        };
        image.src = url;
    };

    var transforms = {
        1: function _() {
            return [1, 0, 0, 1, 0, 0];
        },
        2: function _(width) {
            return [-1, 0, 0, 1, width, 0];
        },
        3: function _(width, height) {
            return [-1, 0, 0, -1, width, height];
        },
        4: function _(width, height) {
            return [1, 0, 0, -1, 0, height];
        },
        5: function _() {
            return [0, 1, 1, 0, 0, 0];
        },
        6: function _(width, height) {
            return [0, 1, -1, 0, height, 0];
        },
        7: function _(width, height) {
            return [0, -1, -1, 0, height, width];
        },
        8: function _(width) {
            return [0, -1, 1, 0, 0, width];
        }
    };

    var fixImageOrientation = function fixImageOrientation(
        ctx,
        width,
        height,
        orientation
    ) {
        // no orientation supplied
        if (orientation === -1) {
            return;
        }

        ctx.transform.apply(ctx, transforms[orientation](width, height));
    };

    // draws the preview image to canvas
    var createPreviewImage = function createPreviewImage(
        data,
        width,
        height,
        orientation
    ) {
        // can't draw on half pixels
        width = Math.round(width);
        height = Math.round(height);

        // draw image
        var canvas = document.createElement('canvas');
        canvas.width = width;
        canvas.height = height;
        var ctx = canvas.getContext('2d');

        // if is rotated incorrectly swap width and height
        if (orientation >= 5 && orientation <= 8) {
            var _ref = [height, width];
            width = _ref[0];
            height = _ref[1];
        }

        // correct image orientation
        fixImageOrientation(ctx, width, height, orientation);

        // draw the image
        ctx.drawImage(data, 0, 0, width, height);

        return canvas;
    };

    var isBitmap = function isBitmap(file) {
        return /^image/.test(file.type) && !/svg/.test(file.type);
    };

    var MAX_WIDTH = 10;
    var MAX_HEIGHT = 10;

    var calculateAverageColor = function calculateAverageColor(image) {
        var scalar = Math.min(MAX_WIDTH / image.width, MAX_HEIGHT / image.height);

        var canvas = document.createElement('canvas');
        var ctx = canvas.getContext('2d');
        var width = (canvas.width = Math.ceil(image.width * scalar));
        var height = (canvas.height = Math.ceil(image.height * scalar));
        ctx.drawImage(image, 0, 0, width, height);
        var data = null;
        try {
            data = ctx.getImageData(0, 0, width, height).data;
        } catch (e) {
            return null;
        }
        var l = data.length;

        var r = 0;
        var g = 0;
        var b = 0;
        var i = 0;

        for (; i < l; i += 4) {
            r += data[i] * data[i];
            g += data[i + 1] * data[i + 1];
            b += data[i + 2] * data[i + 2];
        }

        r = averageColor(r, l);
        g = averageColor(g, l);
        b = averageColor(b, l);

        return { r: r, g: g, b: b };
    };

    var averageColor = function averageColor(c, l) {
        return Math.floor(Math.sqrt(c / (l / 4)));
    };

    var cloneCanvas = function cloneCanvas(origin, target) {
        target = target || document.createElement('canvas');
        target.width = origin.width;
        target.height = origin.height;
        var ctx = target.getContext('2d');
        ctx.drawImage(origin, 0, 0);
        return target;
    };

    var cloneImageData = function cloneImageData(imageData) {
        var id;
        try {
            id = new ImageData(imageData.width, imageData.height);
        } catch (e) {
            var canvas = document.createElement('canvas');
            var ctx = canvas.getContext('2d');
            id = ctx.createImageData(imageData.width, imageData.height);
        }
        id.data.set(new Uint8ClampedArray(imageData.data));
        return id;
    };

    var loadImage = function loadImage(url) {
        return new Promise(function(resolve, reject) {
            var img = new Image();
            img.crossOrigin = 'Anonymous';
            img.onload = function() {
                resolve(img);
            };
            img.onerror = function(e) {
                reject(e);
            };
            img.src = url;
        });
    };

    var createImageWrapperView = function createImageWrapperView(_) {
        // create overlay view
        var OverlayView = createImageOverlayView(_);

        var ImageView = createImageView(_);
        var createWorker = _.utils.createWorker;

        var applyFilter = function applyFilter(root, filter, target) {
            return new Promise(function(resolve) {
                // will store image data for future filter updates
                if (!root.ref.imageData) {
                    root.ref.imageData = target
                        .getContext('2d')
                        .getImageData(0, 0, target.width, target.height);
                }

                // get image data reference
                var imageData = cloneImageData(root.ref.imageData);

                if (!filter || filter.length !== 20) {
                    target.getContext('2d').putImageData(imageData, 0, 0);
                    return resolve();
                }

                var worker = createWorker(ColorMatrixWorker);
                worker.post(
                    {
                        imageData: imageData,
                        colorMatrix: filter
                    },

                    function(response) {
                        // apply filtered colors
                        target.getContext('2d').putImageData(response, 0, 0);

                        // stop worker
                        worker.terminate();

                        // done!
                        resolve();
                    },
                    [imageData.data.buffer]
                );
            });
        };

        var removeImageView = function removeImageView(root, imageView) {
            root.removeChildView(imageView);
            imageView.image.width = 1;
            imageView.image.height = 1;
            imageView._destroy();
        };

        // remove an image
        var shiftImage = function shiftImage(_ref) {
            var root = _ref.root;
            var imageView = root.ref.images.shift();
            imageView.opacity = 0;
            imageView.translateY = -15;
            root.ref.imageViewBin.push(imageView);
            return imageView;
        };

        // add new image
        var pushImage = function pushImage(_ref2) {
            var root = _ref2.root,
                props = _ref2.props,
                image = _ref2.image;
            var id = props.id;
            var item = root.query('GET_ITEM', { id: id });
            if (!item) return;

            var crop = item.getMetadata('crop') || {
                center: {
                    x: 0.5,
                    y: 0.5
                },

                flip: {
                    horizontal: false,
                    vertical: false
                },

                zoom: 1,
                rotation: 0,
                aspectRatio: null
            };

            var background = root.query(
                'GET_IMAGE_TRANSFORM_CANVAS_BACKGROUND_COLOR'
            );

            var markup;
            var resize;
            var dirty = false;
            if (root.query('GET_IMAGE_PREVIEW_MARKUP_SHOW')) {
                markup = item.getMetadata('markup') || [];
                resize = item.getMetadata('resize');
                dirty = true;
            }

            // append image presenter
            var imageView = root.appendChildView(
                root.createChildView(ImageView, {
                    id: id,
                    image: image,
                    crop: crop,
                    resize: resize,
                    markup: markup,
                    dirty: dirty,
                    background: background,
                    opacity: 0,
                    scaleX: 1.15,
                    scaleY: 1.15,
                    translateY: 15
                }),

                root.childViews.length
            );

            root.ref.images.push(imageView);

            // reveal the preview image
            imageView.opacity = 1;
            imageView.scaleX = 1;
            imageView.scaleY = 1;
            imageView.translateY = 0;

            // the preview is now ready to be drawn
            setTimeout(function() {
                root.dispatch('DID_IMAGE_PREVIEW_SHOW', { id: id });
            }, 250);
        };

        var updateImage = function updateImage(_ref3) {
            var root = _ref3.root,
                props = _ref3.props;
            var item = root.query('GET_ITEM', { id: props.id });
            if (!item) return;
            var imageView = root.ref.images[root.ref.images.length - 1];
            imageView.crop = item.getMetadata('crop');
            imageView.background = root.query(
                'GET_IMAGE_TRANSFORM_CANVAS_BACKGROUND_COLOR'
            );

            if (root.query('GET_IMAGE_PREVIEW_MARKUP_SHOW')) {
                imageView.dirty = true;
                imageView.resize = item.getMetadata('resize');
                imageView.markup = item.getMetadata('markup');
            }
        };

        // replace image preview
        var didUpdateItemMetadata = function didUpdateItemMetadata(_ref4) {
            var root = _ref4.root,
                props = _ref4.props,
                action = _ref4.action;
            // only filter and crop trigger redraw
            if (!/crop|filter|markup|resize/.test(action.change.key)) return;

            // no images to update, exit
            if (!root.ref.images.length) return;

            // no item found, exit
            var item = root.query('GET_ITEM', { id: props.id });
            if (!item) return;

            // for now, update existing image when filtering
            if (/filter/.test(action.change.key)) {
                var imageView = root.ref.images[root.ref.images.length - 1];
                applyFilter(root, action.change.value, imageView.image);
                return;
            }

            if (/crop|markup|resize/.test(action.change.key)) {
                var crop = item.getMetadata('crop');
                var image = root.ref.images[root.ref.images.length - 1];

                // if aspect ratio has changed, we need to create a new image
                if (
                    crop &&
                    crop.aspectRatio &&
                    image.crop &&
                    image.crop.aspectRatio &&
                    Math.abs(crop.aspectRatio - image.crop.aspectRatio) > 0.00001
                ) {
                    var _imageView = shiftImage({ root: root });
                    pushImage({
                        root: root,
                        props: props,
                        image: cloneCanvas(_imageView.image)
                    });
                }
                // if not, we can update the current image
                else {
                    updateImage({ root: root, props: props });
                }
            }
        };

        var canCreateImageBitmap = function canCreateImageBitmap(file) {
            // Firefox versions before 58 will freeze when running createImageBitmap
            // in a Web Worker so we detect those versions and return false for support
            var userAgent = window.navigator.userAgent;
            var isFirefox = userAgent.match(/Firefox\/([0-9]+)\./);
            var firefoxVersion = isFirefox ? parseInt(isFirefox[1]) : null;
            if (firefoxVersion !== null && firefoxVersion <= 58) return false;

            return 'createImageBitmap' in window && isBitmap(file);
        };

        /**
         * Write handler for when preview container has been created
         */
        var didCreatePreviewContainer = function didCreatePreviewContainer(_ref5) {
            var root = _ref5.root,
                props = _ref5.props;
            var id = props.id;

            // we need to get the file data to determine the eventual image size
            var item = root.query('GET_ITEM', id);
            if (!item) return;

            // get url to file (we'll revoke it later on when done)
            var fileURL = URL.createObjectURL(item.file);

            // determine image size of this item
            getImageSize(fileURL, function(width, height) {
                // we can now scale the panel to the final size
                root.dispatch('DID_IMAGE_PREVIEW_CALCULATE_SIZE', {
                    id: id,
                    width: width,
                    height: height
                });
            });
        };

        var drawPreview = function drawPreview(_ref6) {
            var root = _ref6.root,
                props = _ref6.props;
            var id = props.id;

            // we need to get the file data to determine the eventual image size
            var item = root.query('GET_ITEM', id);
            if (!item) return;

            // get url to file (we'll revoke it later on when done)
            var fileURL = URL.createObjectURL(item.file);

            // fallback
            var loadPreviewFallback = function loadPreviewFallback() {
                // let's scale the image in the main thread :(
                loadImage(fileURL).then(previewImageLoaded);
            };

            // image is now ready
            var previewImageLoaded = function previewImageLoaded(imageData) {
                // the file url is no longer needed
                URL.revokeObjectURL(fileURL);

                // draw the scaled down version here and use that as source so bitmapdata can be closed
                // orientation info
                var exif = item.getMetadata('exif') || {};
                var orientation = exif.orientation || -1;

                // get width and height from action, and swap if orientation is incorrect
                var width = imageData.width,
                    height = imageData.height;

                // if no width or height, just return early.
                if (!width || !height) return;

                if (orientation >= 5 && orientation <= 8) {
                    var _ref7 = [height, width];
                    width = _ref7[0];
                    height = _ref7[1];
                }

                // scale canvas based on pixel density
                // we multiply by .75 as that creates smaller but still clear images on screens with high res displays
                var pixelDensityFactor = Math.max(1, window.devicePixelRatio * 0.75);

                // we want as much pixels to work with as possible,
                // this multiplies the minimum image resolution,
                // so when zooming in it doesn't get too blurry
                var zoomFactor = root.query('GET_IMAGE_PREVIEW_ZOOM_FACTOR');

                // imaeg scale factor
                var scaleFactor = zoomFactor * pixelDensityFactor;

                // calculate scaled preview image size
                var previewImageRatio = height / width;

                // calculate image preview height and width
                var previewContainerWidth = root.rect.element.width;
                var previewContainerHeight = root.rect.element.height;

                var imageWidth = previewContainerWidth;
                var imageHeight = imageWidth * previewImageRatio;

                if (previewImageRatio > 1) {
                    imageWidth = Math.min(width, previewContainerWidth * scaleFactor);
                    imageHeight = imageWidth * previewImageRatio;
                } else {
                    imageHeight = Math.min(height, previewContainerHeight * scaleFactor);
                    imageWidth = imageHeight / previewImageRatio;
                }

                // transfer to image tag so no canvas memory wasted on iOS
                var previewImage = createPreviewImage(
                    imageData,
                    imageWidth,
                    imageHeight,
                    orientation
                );

                // done
                var done = function done() {
                    // calculate average image color, disabled for now
                    var averageColor = root.query(
                        'GET_IMAGE_PREVIEW_CALCULATE_AVERAGE_IMAGE_COLOR'
                    )
                        ? calculateAverageColor(data)
                        : null;
                    item.setMetadata('color', averageColor, true);

                    // data has been transferred to canvas ( if was ImageBitmap )
                    if ('close' in imageData) {
                        imageData.close();
                    }

                    // show the overlay
                    root.ref.overlayShadow.opacity = 1;

                    // create the first image
                    pushImage({ root: root, props: props, image: previewImage });
                };

                // apply filter
                var filter = item.getMetadata('filter');
                if (filter) {
                    applyFilter(root, filter, previewImage).then(done);
                } else {
                    done();
                }
            };

            // if we support scaling using createImageBitmap we use a worker
            if (canCreateImageBitmap(item.file)) {
                // let's scale the image in a worker
                var worker = createWorker(BitmapWorker);

                worker.post(
                    {
                        file: item.file
                    },

                    function(imageBitmap) {
                        // destroy worker
                        worker.terminate();

                        // no bitmap returned, must be something wrong,
                        // try the oldschool way
                        if (!imageBitmap) {
                            loadPreviewFallback();
                            return;
                        }

                        // yay we got our bitmap, let's continue showing the preview
                        previewImageLoaded(imageBitmap);
                    }
                );
            } else {
                // create fallback preview
                loadPreviewFallback();
            }
        };

        /**
         * Write handler for when the preview image is ready to be animated
         */
        var didDrawPreview = function didDrawPreview(_ref8) {
            var root = _ref8.root;
            // get last added image
            var image = root.ref.images[root.ref.images.length - 1];
            image.translateY = 0;
            image.scaleX = 1.0;
            image.scaleY = 1.0;
            image.opacity = 1;
        };

        /**
         * Write handler for when the preview has been loaded
         */
        var restoreOverlay = function restoreOverlay(_ref9) {
            var root = _ref9.root;
            root.ref.overlayShadow.opacity = 1;
            root.ref.overlayError.opacity = 0;
            root.ref.overlaySuccess.opacity = 0;
        };

        var didThrowError = function didThrowError(_ref10) {
            var root = _ref10.root;
            root.ref.overlayShadow.opacity = 0.25;
            root.ref.overlayError.opacity = 1;
        };

        var didCompleteProcessing = function didCompleteProcessing(_ref11) {
            var root = _ref11.root;
            root.ref.overlayShadow.opacity = 0.25;
            root.ref.overlaySuccess.opacity = 1;
        };

        /**
         * Constructor
         */
        var create = function create(_ref12) {
            var root = _ref12.root;
            // image view
            root.ref.images = [];

            // the preview image data (we need this to filter the image)
            root.ref.imageData = null;

            // image bin
            root.ref.imageViewBin = [];

            // image overlays
            root.ref.overlayShadow = root.appendChildView(
                root.createChildView(OverlayView, {
                    opacity: 0,
                    status: 'idle'
                })
            );

            root.ref.overlaySuccess = root.appendChildView(
                root.createChildView(OverlayView, {
                    opacity: 0,
                    status: 'success'
                })
            );

            root.ref.overlayError = root.appendChildView(
                root.createChildView(OverlayView, {
                    opacity: 0,
                    status: 'failure'
                })
            );
        };

        return _.utils.createView({
            name: 'image-preview-wrapper',
            create: create,
            styles: ['height'],
            apis: ['height'],
            destroy: function destroy(_ref13) {
                var root = _ref13.root;
                // we resize the image so memory on iOS 12 is released more quickly (it seems)
                root.ref.images.forEach(function(imageView) {
                    imageView.image.width = 1;
                    imageView.image.height = 1;
                });
            },
            didWriteView: function didWriteView(_ref14) {
                var root = _ref14.root;
                root.ref.images.forEach(function(imageView) {
                    imageView.dirty = false;
                });
            },
            write: _.utils.createRoute(
                {
                    // image preview stated
                    DID_IMAGE_PREVIEW_DRAW: didDrawPreview,
                    DID_IMAGE_PREVIEW_CONTAINER_CREATE: didCreatePreviewContainer,
                    DID_FINISH_CALCULATE_PREVIEWSIZE: drawPreview,
                    DID_UPDATE_ITEM_METADATA: didUpdateItemMetadata,

                    // file states
                    DID_THROW_ITEM_LOAD_ERROR: didThrowError,
                    DID_THROW_ITEM_PROCESSING_ERROR: didThrowError,
                    DID_THROW_ITEM_INVALID: didThrowError,
                    DID_COMPLETE_ITEM_PROCESSING: didCompleteProcessing,
                    DID_START_ITEM_PROCESSING: restoreOverlay,
                    DID_REVERT_ITEM_PROCESSING: restoreOverlay
                },

                function(_ref15) {
                    var root = _ref15.root;
                    // views on death row
                    var viewsToRemove = root.ref.imageViewBin.filter(function(imageView) {
                        return imageView.opacity === 0;
                    });

                    // views to retain
                    root.ref.imageViewBin = root.ref.imageViewBin.filter(function(
                        imageView
                    ) {
                        return imageView.opacity > 0;
                    });

                    // remove these views
                    viewsToRemove.forEach(function(imageView) {
                        return removeImageView(root, imageView);
                    });
                    viewsToRemove.length = 0;
                }
            )
        });
    };

    /**
     * Image Preview Plugin
     */
    var plugin = function plugin(fpAPI) {
        var addFilter = fpAPI.addFilter,
            utils = fpAPI.utils;
        var Type = utils.Type,
            createRoute = utils.createRoute,
            isFile = utils.isFile;

        // imagePreviewView
        var imagePreviewView = createImageWrapperView(fpAPI);

        // called for each view that is created right after the 'create' method
        addFilter('CREATE_VIEW', function(viewAPI) {
            // get reference to created view
            var is = viewAPI.is,
                view = viewAPI.view,
                query = viewAPI.query;

            // only hook up to item view and only if is enabled for this cropper
            if (!is('file') || !query('GET_ALLOW_IMAGE_PREVIEW')) return;

            // create the image preview plugin, but only do so if the item is an image
            var didLoadItem = function didLoadItem(_ref) {
                var root = _ref.root,
                    props = _ref.props;
                var id = props.id;
                var item = query('GET_ITEM', id);

                // item could theoretically have been removed in the mean time
                if (!item || !isFile(item.file) || item.archived) return;

                // get the file object
                var file = item.file;

                // exit if this is not an image
                if (!isPreviewableImage(file)) return;

                // test if is filtered
                if (!query('GET_IMAGE_PREVIEW_FILTER_ITEM')(item)) return;

                // exit if image size is too high and no createImageBitmap support
                // this would simply bring the browser to its knees and that is not what we want
                var supportsCreateImageBitmap = 'createImageBitmap' in (window || {});
                var maxPreviewFileSize = query('GET_IMAGE_PREVIEW_MAX_FILE_SIZE');
                if (
                    !supportsCreateImageBitmap &&
                    maxPreviewFileSize &&
                    file.size > maxPreviewFileSize
                )
                    return;

                // set preview view
                root.ref.imagePreview = view.appendChildView(
                    view.createChildView(imagePreviewView, { id: id })
                );

                // update height if is fixed
                var fixedPreviewHeight = root.query('GET_IMAGE_PREVIEW_HEIGHT');
                if (fixedPreviewHeight) {
                    root.dispatch('DID_UPDATE_PANEL_HEIGHT', {
                        id: item.id,
                        height: fixedPreviewHeight
                    });
                }

                // now ready
                var queue =
                    !supportsCreateImageBitmap &&
                    file.size > query('GET_IMAGE_PREVIEW_MAX_INSTANT_PREVIEW_FILE_SIZE');
                root.dispatch('DID_IMAGE_PREVIEW_CONTAINER_CREATE', { id: id }, queue);
            };

            var rescaleItem = function rescaleItem(root, props) {
                if (!root.ref.imagePreview) return;
                var id = props.id;

                // get item
                var item = root.query('GET_ITEM', { id: id });
                if (!item) return;

                // if is fixed height or panel has aspect ratio, exit here, height has already been defined
                var panelAspectRatio = root.query('GET_PANEL_ASPECT_RATIO');
                var itemPanelAspectRatio = root.query('GET_ITEM_PANEL_ASPECT_RATIO');
                var fixedHeight = root.query('GET_IMAGE_PREVIEW_HEIGHT');
                if (panelAspectRatio || itemPanelAspectRatio || fixedHeight) return;

                // no data!
                var _root$ref = root.ref,
                    imageWidth = _root$ref.imageWidth,
                    imageHeight = _root$ref.imageHeight;
                if (!imageWidth || !imageHeight) return;

                // get height min and max
                var minPreviewHeight = root.query('GET_IMAGE_PREVIEW_MIN_HEIGHT');
                var maxPreviewHeight = root.query('GET_IMAGE_PREVIEW_MAX_HEIGHT');

                // orientation info
                var exif = item.getMetadata('exif') || {};
                var orientation = exif.orientation || -1;

                // get width and height from action, and swap of orientation is incorrect
                if (orientation >= 5 && orientation <= 8) {
                    var _ref2 = [imageHeight, imageWidth];
                    imageWidth = _ref2[0];
                    imageHeight = _ref2[1];
                }

                // scale up width and height when we're dealing with an SVG
                if (!isBitmap(item.file) || root.query('GET_IMAGE_PREVIEW_UPSCALE')) {
                    var scalar = 2048 / imageWidth;
                    imageWidth *= scalar;
                    imageHeight *= scalar;
                }

                // image aspect ratio
                var imageAspectRatio = imageHeight / imageWidth;

                // we need the item to get to the crop size
                var previewAspectRatio =
                    (item.getMetadata('crop') || {}).aspectRatio || imageAspectRatio;

                // preview height range
                var previewHeightMax = Math.max(
                    minPreviewHeight,
                    Math.min(imageHeight, maxPreviewHeight)
                );

                var itemWidth = root.rect.element.width;
                var previewHeight = Math.min(
                    itemWidth * previewAspectRatio,
                    previewHeightMax
                );

                // request update to panel height
                root.dispatch('DID_UPDATE_PANEL_HEIGHT', {
                    id: item.id,
                    height: previewHeight
                });
            };

            var didResizeView = function didResizeView(_ref3) {
                var root = _ref3.root;
                // actions in next write operation
                root.ref.shouldRescale = true;
            };

            var didUpdateItemMetadata = function didUpdateItemMetadata(_ref4) {
                var root = _ref4.root,
                    action = _ref4.action;
                if (action.change.key !== 'crop') return;

                // actions in next write operation
                root.ref.shouldRescale = true;
            };

            var didCalculatePreviewSize = function didCalculatePreviewSize(_ref5) {
                var root = _ref5.root,
                    action = _ref5.action;
                // remember dimensions
                root.ref.imageWidth = action.width;
                root.ref.imageHeight = action.height;

                // actions in next write operation
                root.ref.shouldRescale = true;
                root.ref.shouldDrawPreview = true;

                // as image load could take a while and fire when draw loop is resting we need to give it a kick
                root.dispatch('KICK');
            };

            // start writing
            view.registerWriter(
                createRoute(
                    {
                        DID_RESIZE_ROOT: didResizeView,
                        DID_STOP_RESIZE: didResizeView,
                        DID_LOAD_ITEM: didLoadItem,
                        DID_IMAGE_PREVIEW_CALCULATE_SIZE: didCalculatePreviewSize,
                        DID_UPDATE_ITEM_METADATA: didUpdateItemMetadata
                    },

                    function(_ref6) {
                        var root = _ref6.root,
                            props = _ref6.props;
                        // no preview view attached
                        if (!root.ref.imagePreview) return;

                        // don't do anything while hidden
                        if (root.rect.element.hidden) return;

                        // resize the item panel
                        if (root.ref.shouldRescale) {
                            rescaleItem(root, props);
                            root.ref.shouldRescale = false;
                        }

                        if (root.ref.shouldDrawPreview) {
                            // queue till next frame so we're sure the height has been applied this forces the draw image call inside the wrapper view to use the correct height
                            requestAnimationFrame(function() {
                                // this requestAnimationFrame nesting is horrible but it fixes an issue with 100hz displays on Chrome
                                // https://github.com/pqina/filepond-plugin-image-preview/issues/57
                                requestAnimationFrame(function() {
                                    root.dispatch('DID_FINISH_CALCULATE_PREVIEWSIZE', {
                                        id: props.id
                                    });
                                });
                            });

                            root.ref.shouldDrawPreview = false;
                        }
                    }
                )
            );
        });

        // expose plugin
        return {
            options: {
                // Enable or disable image preview
                allowImagePreview: [true, Type.BOOLEAN],

                // filters file items to determine which are shown as preview
                imagePreviewFilterItem: [
                    function() {
                        return true;
                    },
                    Type.FUNCTION
                ],

                // Fixed preview height
                imagePreviewHeight: [null, Type.INT],

                // Min image height
                imagePreviewMinHeight: [44, Type.INT],

                // Max image height
                imagePreviewMaxHeight: [256, Type.INT],

                // Max size of preview file for when createImageBitmap is not supported
                imagePreviewMaxFileSize: [null, Type.INT],

                // The amount of extra pixels added to the image preview to allow comfortable zooming
                imagePreviewZoomFactor: [2, Type.INT],

                // Should we upscale small images to fit the max bounding box of the preview area
                imagePreviewUpscale: [false, Type.BOOLEAN],

                // Max size of preview file that we allow to try to instant preview if createImageBitmap is not supported, else image is queued for loading
                imagePreviewMaxInstantPreviewFileSize: [1000000, Type.INT],

                // Style of the transparancy indicator used behind images
                imagePreviewTransparencyIndicator: [null, Type.STRING],

                // Enables or disables reading average image color
                imagePreviewCalculateAverageImageColor: [false, Type.BOOLEAN],

                // Enables or disables the previewing of markup
                imagePreviewMarkupShow: [true, Type.BOOLEAN],

                // Allows filtering of markup to only show certain shapes
                imagePreviewMarkupFilter: [
                    function() {
                        return true;
                    },
                    Type.FUNCTION
                ]
            }
        };
    };

    // fire pluginloaded event if running in browser, this allows registering the plugin when using async script tags
    var isBrowser =
        typeof window !== 'undefined' && typeof window.document !== 'undefined';
    if (isBrowser) {
        document.dispatchEvent(
            new CustomEvent('FilePond:pluginloaded', { detail: plugin })
        );
    }

    return plugin;
});

/*!
 * FilePondPluginFileValidateSize 2.2.8
 * Licensed under MIT, https://opensource.org/licenses/MIT/
 * Please visit https://pqina.nl/filepond/ for details.
 */

/* eslint-disable */

(function(global, factory) {
    typeof exports === 'object' && typeof module !== 'undefined'
        ? (module.exports = factory())
        : typeof define === 'function' && define.amd
            ? define(factory)
            : ((global = global || self), (global.FilePondPluginFileValidateSize = factory()));
})(this, function() {
    'use strict';

    var plugin = function plugin(_ref) {
        var addFilter = _ref.addFilter,
            utils = _ref.utils;
        // get quick reference to Type utils
        var Type = utils.Type,
            replaceInString = utils.replaceInString,
            toNaturalFileSize = utils.toNaturalFileSize;

        // filtering if an item is allowed in hopper
        addFilter('ALLOW_HOPPER_ITEM', function(file, _ref2) {
            var query = _ref2.query;
            if (!query('GET_ALLOW_FILE_SIZE_VALIDATION')) {
                return true;
            }

            var sizeMax = query('GET_MAX_FILE_SIZE');
            if (sizeMax !== null && file.size > sizeMax) {
                return false;
            }

            var sizeMin = query('GET_MIN_FILE_SIZE');
            if (sizeMin !== null && file.size < sizeMin) {
                return false;
            }

            return true;
        });

        // called for each file that is loaded
        // right before it is set to the item state
        // should return a promise
        addFilter('LOAD_FILE', function(file, _ref3) {
            var query = _ref3.query;
            return new Promise(function(resolve, reject) {
                // if not allowed, all fine, exit
                if (!query('GET_ALLOW_FILE_SIZE_VALIDATION')) {
                    return resolve(file);
                }

                // check if file should be filtered
                var fileFilter = query('GET_FILE_VALIDATE_SIZE_FILTER');
                if (fileFilter && !fileFilter(file)) {
                    return resolve(file);
                }

                // reject or resolve based on file size
                var sizeMax = query('GET_MAX_FILE_SIZE');
                if (sizeMax !== null && file.size > sizeMax) {
                    reject({
                        status: {
                            main: query('GET_LABEL_MAX_FILE_SIZE_EXCEEDED'),
                            sub: replaceInString(query('GET_LABEL_MAX_FILE_SIZE'), {
                                filesize: toNaturalFileSize(
                                    sizeMax,
                                    '.',
                                    query('GET_FILE_SIZE_BASE'),
                                    query('GET_FILE_SIZE_LABELS', query)
                                ),
                            }),
                        },
                    });

                    return;
                }

                // reject or resolve based on file size
                var sizeMin = query('GET_MIN_FILE_SIZE');
                if (sizeMin !== null && file.size < sizeMin) {
                    reject({
                        status: {
                            main: query('GET_LABEL_MIN_FILE_SIZE_EXCEEDED'),
                            sub: replaceInString(query('GET_LABEL_MIN_FILE_SIZE'), {
                                filesize: toNaturalFileSize(
                                    sizeMin,
                                    '.',
                                    query('GET_FILE_SIZE_BASE'),
                                    query('GET_FILE_SIZE_LABELS', query)
                                ),
                            }),
                        },
                    });

                    return;
                }

                // returns the current option value
                var totalSizeMax = query('GET_MAX_TOTAL_FILE_SIZE');
                if (totalSizeMax !== null) {
                    // get the current total file size
                    var currentTotalSize = query('GET_ACTIVE_ITEMS').reduce(function(total, item) {
                        return total + item.fileSize;
                    }, 0);

                    // get the size of the new file
                    if (currentTotalSize > totalSizeMax) {
                        reject({
                            status: {
                                main: query('GET_LABEL_MAX_TOTAL_FILE_SIZE_EXCEEDED'),
                                sub: replaceInString(query('GET_LABEL_MAX_TOTAL_FILE_SIZE'), {
                                    filesize: toNaturalFileSize(
                                        totalSizeMax,
                                        '.',
                                        query('GET_FILE_SIZE_BASE'),
                                        query('GET_FILE_SIZE_LABELS', query)
                                    ),
                                }),
                            },
                        });

                        return;
                    }
                }

                // file is fine, let's pass it back
                resolve(file);
            });
        });

        return {
            options: {
                // Enable or disable file type validation
                allowFileSizeValidation: [true, Type.BOOLEAN],

                // Max individual file size in bytes
                maxFileSize: [null, Type.INT],

                // Min individual file size in bytes
                minFileSize: [null, Type.INT],

                // Max total file size in bytes
                maxTotalFileSize: [null, Type.INT],

                // Filter the files that need to be validated for size
                fileValidateSizeFilter: [null, Type.FUNCTION],

                // error labels
                labelMinFileSizeExceeded: ['File is too small', Type.STRING],
                labelMinFileSize: ['Minimum file size is {filesize}', Type.STRING],

                labelMaxFileSizeExceeded: ['File is too large', Type.STRING],
                labelMaxFileSize: ['Maximum file size is {filesize}', Type.STRING],

                labelMaxTotalFileSizeExceeded: ['Maximum total size exceeded', Type.STRING],
                labelMaxTotalFileSize: ['Maximum total file size is {filesize}', Type.STRING],
            },
        };
    };

    // fire pluginloaded event if running in browser, this allows registering the plugin when using async script tags
    var isBrowser = typeof window !== 'undefined' && typeof window.document !== 'undefined';
    if (isBrowser) {
        document.dispatchEvent(new CustomEvent('FilePond:pluginloaded', { detail: plugin }));
    }

    return plugin;
});

/*!
 * FilePondPluginFileValidateType 1.2.9
 * Licensed under MIT, https://opensource.org/licenses/MIT/
 * Please visit https://pqina.nl/filepond/ for details.
 */

/* eslint-disable */

(function(global, factory) {
    typeof exports === 'object' && typeof module !== 'undefined'
        ? (module.exports = factory())
        : typeof define === 'function' && define.amd
            ? define(factory)
            : ((global = global || self), (global.FilePondPluginFileValidateType = factory()));
})(this, function() {
    'use strict';

    var plugin = function plugin(_ref) {
        var addFilter = _ref.addFilter,
            utils = _ref.utils;
        // get quick reference to Type utils
        var Type = utils.Type,
            isString = utils.isString,
            replaceInString = utils.replaceInString,
            guesstimateMimeType = utils.guesstimateMimeType,
            getExtensionFromFilename = utils.getExtensionFromFilename,
            getFilenameFromURL = utils.getFilenameFromURL;

        var mimeTypeMatchesWildCard = function mimeTypeMatchesWildCard(mimeType, wildcard) {
            var mimeTypeGroup = (/^[^/]+/.exec(mimeType) || []).pop(); // image/png -> image
            var wildcardGroup = wildcard.slice(0, -2); // image/* -> image
            return mimeTypeGroup === wildcardGroup;
        };

        var isValidMimeType = function isValidMimeType(acceptedTypes, userInputType) {
            return acceptedTypes.some(function(acceptedType) {
                // accepted is wildcard mime type
                if (/\*$/.test(acceptedType)) {
                    return mimeTypeMatchesWildCard(userInputType, acceptedType);
                }

                // is normal mime type
                return acceptedType === userInputType;
            });
        };

        var getItemType = function getItemType(item) {
            // if the item is a url we guess the mime type by the extension
            var type = '';
            if (isString(item)) {
                var filename = getFilenameFromURL(item);
                var extension = getExtensionFromFilename(filename);
                if (extension) {
                    type = guesstimateMimeType(extension);
                }
            } else {
                type = item.type;
            }

            return type;
        };

        var validateFile = function validateFile(item, acceptedFileTypes, typeDetector) {
            // no types defined, everything is allowed \o/
            if (acceptedFileTypes.length === 0) {
                return true;
            }

            // gets the item type
            var type = getItemType(item);

            // no type detector, test now
            if (!typeDetector) {
                return isValidMimeType(acceptedFileTypes, type);
            }

            // use type detector
            return new Promise(function(resolve, reject) {
                typeDetector(item, type)
                    .then(function(detectedType) {
                        if (isValidMimeType(acceptedFileTypes, detectedType)) {
                            resolve();
                        } else {
                            reject();
                        }
                    })
                    .catch(reject);
            });
        };

        var applyMimeTypeMap = function applyMimeTypeMap(map) {
            return function(acceptedFileType) {
                return map[acceptedFileType] === null
                    ? false
                    : map[acceptedFileType] || acceptedFileType;
            };
        };

        // setup attribute mapping for accept
        addFilter('SET_ATTRIBUTE_TO_OPTION_MAP', function(map) {
            return Object.assign(map, {
                accept: 'acceptedFileTypes',
            });
        });

        // filtering if an item is allowed in hopper
        addFilter('ALLOW_HOPPER_ITEM', function(file, _ref2) {
            var query = _ref2.query;
            // if we are not doing file type validation exit
            if (!query('GET_ALLOW_FILE_TYPE_VALIDATION')) {
                return true;
            }

            // we validate the file against the accepted file types
            return validateFile(file, query('GET_ACCEPTED_FILE_TYPES'));
        });

        // called for each file that is loaded
        // right before it is set to the item state
        // should return a promise
        addFilter('LOAD_FILE', function(file, _ref3) {
            var query = _ref3.query;
            return new Promise(function(resolve, reject) {
                if (!query('GET_ALLOW_FILE_TYPE_VALIDATION')) {
                    resolve(file);
                    return;
                }

                var acceptedFileTypes = query('GET_ACCEPTED_FILE_TYPES');

                // custom type detector method
                var typeDetector = query('GET_FILE_VALIDATE_TYPE_DETECT_TYPE');

                // if invalid, exit here
                var validationResult = validateFile(file, acceptedFileTypes, typeDetector);

                var handleRejection = function handleRejection() {
                    var acceptedFileTypesMapped = acceptedFileTypes
                        .map(
                            applyMimeTypeMap(
                                query('GET_FILE_VALIDATE_TYPE_LABEL_EXPECTED_TYPES_MAP')
                            )
                        )
                        .filter(function(label) {
                            return label !== false;
                        });

                    var acceptedFileTypesMappedUnique = acceptedFileTypesMapped.filter(function(
                        item,
                        index
                    ) {
                        return acceptedFileTypesMapped.indexOf(item) === index;
                    });

                    reject({
                        status: {
                            main: query('GET_LABEL_FILE_TYPE_NOT_ALLOWED'),
                            sub: replaceInString(
                                query('GET_FILE_VALIDATE_TYPE_LABEL_EXPECTED_TYPES'),
                                {
                                    allTypes: acceptedFileTypesMappedUnique.join(', '),
                                    allButLastType: acceptedFileTypesMappedUnique
                                        .slice(0, -1)
                                        .join(', '),
                                    lastType:
                                        acceptedFileTypesMappedUnique[
                                        acceptedFileTypesMappedUnique.length - 1
                                            ],
                                }
                            ),
                        },
                    });
                };

                // has returned new filename immidiately
                if (typeof validationResult === 'boolean') {
                    if (!validationResult) {
                        return handleRejection();
                    }
                    return resolve(file);
                }

                // is promise
                validationResult
                    .then(function() {
                        resolve(file);
                    })
                    .catch(handleRejection);
            });
        });

        // expose plugin
        return {
            // default options
            options: {
                // Enable or disable file type validation
                allowFileTypeValidation: [true, Type.BOOLEAN],

                // What file types to accept
                acceptedFileTypes: [[], Type.ARRAY],
                // - must be comma separated
                // - mime types: image/png, image/jpeg, image/gif
                // - extensions: .png, .jpg, .jpeg ( not enabled yet )
                // - wildcards: image/*

                // label to show when a type is not allowed
                labelFileTypeNotAllowed: ['File is of invalid type', Type.STRING],

                // nicer label
                fileValidateTypeLabelExpectedTypes: [
                    'Expects {allButLastType} or {lastType}',
                    Type.STRING,
                ],

                // map mime types to extensions
                fileValidateTypeLabelExpectedTypesMap: [{}, Type.OBJECT],

                // Custom function to detect type of file
                fileValidateTypeDetectType: [null, Type.FUNCTION],
            },
        };
    };

    // fire pluginloaded event if running in browser, this allows registering the plugin when using async script tags
    var isBrowser = typeof window !== 'undefined' && typeof window.document !== 'undefined';
    if (isBrowser) {
        document.dispatchEvent(new CustomEvent('FilePond:pluginloaded', { detail: plugin }));
    }

    return plugin;
});

// Register the plugin
FilePond.registerPlugin(FilePondPluginImagePreview);
FilePond.registerPlugin(FilePondPluginFileValidateSize);
FilePond.registerPlugin(FilePondPluginFileValidateType);
