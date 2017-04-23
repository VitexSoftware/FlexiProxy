(function(){var f=this;function g(a){a=a.split(".");for(var b=f,c;c=a.shift();)if(null!=b[c])b=b[c];else return null;return b}
function h(a,b,c){return a.call.apply(a.bind,arguments)}
function k(a,b,c){if(!a)throw Error();if(2<arguments.length){var d=Array.prototype.slice.call(arguments,2);return function(){var c=Array.prototype.slice.call(arguments);Array.prototype.unshift.apply(c,d);return a.apply(b,c)}}return function(){return a.apply(b,arguments)}}
function l(a,b,c){Function.prototype.bind&&-1!=Function.prototype.bind.toString().indexOf("native code")?l=h:l=k;return l.apply(null,arguments)}
var m=Date.now||function(){return+new Date};
function n(a,b){var c=a.split("."),d=f;c[0]in d||!d.execScript||d.execScript("var "+c[0]);for(var e;c.length&&(e=c.shift());)c.length||void 0===b?d[e]&&d[e]!==Object.prototype[e]?d=d[e]:d=d[e]={}:d[e]=b}
;function p(){this.h=this.h;this.m=this.m}
p.prototype.h=!1;p.prototype.dispose=function(){this.h||(this.h=!0,this.o())};
p.prototype.o=function(){if(this.m)for(;this.m.length;)this.m.shift()()};var q=window.yt&&window.yt.config_||window.ytcfg&&window.ytcfg.data_||{};n("yt.config_",q);function u(a){p.call(this);this.a=[];this.a[4]=[];this.a[3]=[];this.a[2]=[];this.a[1]=[];this.a[0]=[];a=a||{};this.f=0;this.G=a.timeout||1;this.c={};this.l=u.a;this.s=this.b=this.j=0;this.u=this.i=!1;this.g=[];this.B=l(this.I,this);this.F=l(this.K,this);this.C=l(this.H,this);this.D=l(this.J,this);this.v=!1;this.A=!!window.requestIdleCallback;(this.w=!!a.useRaf&&!!window.requestAnimationFrame)&&document.addEventListener("visibilitychange",this.B)}
(function(){var a=u;function b(){}
b.prototype=p.prototype;a.M=p.prototype;a.prototype=new b;a.prototype.constructor=a;a.N=function(a,b,e){for(var c=Array(arguments.length-2),d=2;d<arguments.length;d++)c[d-2]=arguments[d];return p.prototype[b].apply(a,c)}})();
u.b=1E3/60;u.c=3E3;u.f=300;u.g=3;u.a=u.b-3;function v(a,b){var c=m();w(b);c=m()-c;a.i||(a.l-=c)}
function x(a,b,c,d){++a.s;if(10==c)return v(a,b),a.s;var e=a.s;a.c[e]=b;a.i&&!d?a.g.push({id:e,L:c}):(a.a[c].push(e),a.u||a.i||(0!=a.b&&y(a)!=a.j&&z(a),a.start()));return e}
function A(a){a.g.length=0;for(var b=4;0<=b;b--)a.a[b].length=0;a.c={};z(a)}
function y(a){for(var b=4;b>=a.f;b--)if(0<a.a[b].length)return 0<b?!document.hidden&&a.w?3:2:1;return 0}
function w(a){try{a()}catch(b){(a=g("yt.logging.errors.log"))&&a(b)}}
u.prototype.H=function(a){var b=void 0;a&&(b=a.timeRemaining());this.v=!0;B(this,b);this.v=!1};
u.prototype.K=function(){B(this)};
u.prototype.J=function(){B(this)};
u.prototype.I=function(){this.b&&(z(this),this.start())};
function B(a,b){z(a);a.i=!0;for(var c=m()+(b||a.l),d=a.a[4];d.length;){var e=d.shift(),r=a.c[e];delete a.c[e];r&&w(r)}d=a.v?0:1;d=a.f>d?a.f:d;if(!(m()>=c)){do{a:{for(var e=a,r=d,t=3;t>=r;t--)for(var E=e.a[t];E.length;){var F=E.shift(),G=e.c[F];delete e.c[F];if(G){e=G;break a}}e=null}e&&w(e)}while(e&&m()<c)}a.i=!1;c=0;for(d=a.g.length;c<d;c++)e=a.g[c],a.a[e.L].push(e.id);a.l=u.a;a:{for(c=3;0<=c;c--)if(a.a[c].length){c=!0;break a}c=!1}(c||a.g.length)&&a.start();a.g.length=0}
u.prototype.start=function(){this.u=!1;if(0==this.b)switch(this.j=y(this),this.j){case 1:var a=this.C;this.b=this.A?window.requestIdleCallback(a,{timeout:3E3}):window.setTimeout(a,300);break;case 2:this.b=window.setTimeout(this.F,this.G);break;case 3:this.b=window.requestAnimationFrame(this.D)}};
function z(a){if(a.b){switch(a.j){case 1:var b=a.b;a.A?window.cancelIdleCallback(b):window.clearTimeout(b);break;case 2:window.clearTimeout(a.b);break;case 3:window.cancelAnimationFrame(a.b)}a.b=0}}
u.prototype.o=function(){A(this);z(this);this.w&&document.removeEventListener("visibilitychange",this.B);u.M.o.call(this)};function C(){var a=g("yt.scheduler.instance.instance_");if(!a||a.h)a=new u(("scheduler"in q?q.scheduler:void 0)||{}),n("yt.scheduler.instance.instance_",a);return a}
function D(){var a=g("yt.scheduler.instance.instance_");a&&(a&&"function"==typeof a.dispose&&a.dispose(),n("yt.scheduler.instance.instance_",null))}
function H(){A(C())}
var I=g("yt.scheduler.instance.timerIdMap_")||{};function J(a,b,c){if(0==c||void 0===c)return c=void 0===c,-x(C(),a,b,c);var d=window.setTimeout(function(){var c=x(C(),a,b);I[d]=c},c);
return d}
function K(a){v(C(),a)}
function L(a){var b=C();if(0>a)delete b.c[-a];else{var c=I[a];c?(delete b.c[c],delete I[a]):window.clearTimeout(a)}}
var M=0,N=0;function O(){return"SCHEDULER_SOFT_STATE_TIMER"in q?q.SCHEDULER_SOFT_STATE_TIMER:800}
function P(a){var b=g("ytcsi.tick");b&&b(a)}
function Q(){P("jse");R()}
function R(){window.clearTimeout(M);C().start()}
function S(){var a=C();z(a);a.u=!0;window.clearTimeout(M);M=window.setTimeout(Q,O())}
function T(){window.clearTimeout(N);N=window.setTimeout(function(){P("jset");U(0)},O())}
function U(a){T();var b=C();b.f=a;b.start()}
function V(a){T();var b=C();b.f>a&&(b.f=a,b.start())}
function W(){window.clearTimeout(N);var a=C();a.f=0;a.start()}
;g("yt.scheduler.initialized")||(n("yt.scheduler.instance.dispose",D),n("yt.scheduler.instance.addJob",J),n("yt.scheduler.instance.addImmediateJob",K),n("yt.scheduler.instance.cancelJob",L),n("yt.scheduler.instance.cancelAllJobs",H),n("yt.scheduler.instance.start",R),n("yt.scheduler.instance.pause",S),n("yt.scheduler.instance.setPriorityThreshold",U),n("yt.scheduler.instance.enablePriorityThreshold",V),n("yt.scheduler.instance.clearPriorityThreshold",W),n("yt.scheduler.initialized",!0));}).call(this);
