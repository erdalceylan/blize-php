(window.webpackJsonp=window.webpackJsonp||[]).push([[4],{"56ro":function(n,t,e){"use strict";e.d(t,"a",function(){return c});var o=e("tk/3"),i=e("AytR"),r=e("fXoL");let c=(()=>{class n{constructor(n){this.http=n}getGroupList(){return this.http.get(i.a.HTTP_PREFIX+"/messages")}getDetail(n){return this.http.get(i.a.HTTP_PREFIX+"/messages/"+n)}add(n,t){return this.http.post(i.a.HTTP_PREFIX+"/messages/add/"+n,(new o.d).set("text",t))}read(n){return this.http.get(i.a.HTTP_PREFIX+"/messages/read/"+n)}}return n.\u0275fac=function(t){return new(t||n)(r.Tb(o.b))},n.\u0275prov=r.Gb({token:n,factory:n.\u0275fac,providedIn:"root"}),n})()},"6BoG":function(n,t,e){"use strict";e.d(t,"a",function(){return r});var o=e("XNiG"),i=e("fXoL");let r=(()=>{class n{constructor(){this.onMessage=new o.a,this.onRead=new o.a}}return n.\u0275fac=function(t){return new(t||n)},n.\u0275prov=i.Gb({token:n,factory:n.\u0275fac,providedIn:"root"}),n})()},Oqma:function(n,t,e){"use strict";e.d(t,"a",function(){return y});var o=e("tyNb"),i=e("/pI1"),r=e("0xcB"),c=e("LGct"),s=e("fXoL"),a=e("56ro"),l=e("caAo"),g=e("OlZr"),d=e("yFR0"),m=e("6BoG"),u=e("ofXK"),h=e("3Pt+");const O=["scrollContent"];function P(n,t){if(1&n&&s.zc(0),2&n){const n=s.ac();let t=null;s.Ac(null==(t=n.getTo())?null:t.nameShort())}}function C(n,t){if(1&n&&s.Lb(0,"img",29),2&n){const n=s.ac();let t=null;s.gc("src",n.ss.API_IMAGE_PREFIX+(null==(t=n.getTo())?null:t.image),s.pc)}}function M(n,t){1&n&&(s.Pb(0,"span",30),s.Lb(1,"span",31),s.Lb(2,"span",31),s.Lb(3,"span",31),s.Ob())}function _(n,t){if(1&n&&s.zc(0),2&n){const n=s.ac().$implicit;s.Ac(null==n.from?null:n.from.nameShort())}}function b(n,t){if(1&n&&s.Lb(0,"img",29),2&n){const n=s.ac().$implicit,t=s.ac();s.gc("src",t.ss.API_IMAGE_PREFIX+(null==n.from?null:n.from.image),s.pc)}}const p=function(n){return{read:n}};function f(n,t){if(1&n&&s.Lb(0,"i",37),2&n){const n=s.ac().$implicit;s.gc("ngClass",s.kc(1,p,n.read))}}const v=function(n){return{me:n}};function w(n,t){if(1&n&&(s.Pb(0,"div",32),s.Pb(1,"div",33),s.Pb(2,"div",2),s.xc(3,_,1,1,"ng-template",3),s.xc(4,b,1,1,"img",4),s.Ob(),s.Pb(5,"div",34),s.zc(6),s.Pb(7,"span",35),s.xc(8,f,1,3,"i",36),s.zc(9),s.bc(10,"date"),s.Ob(),s.Ob(),s.Ob(),s.Ob()),2&n){const n=t.$implicit,e=s.ac();s.gc("ngClass",s.kc(10,v,(null==e.usersService.session?null:e.usersService.session.id)==(null==n.from?null:n.from.id))),s.zb(2),s.Ab("data-first-chars",null==n.from?null:n.from.firstChar()),s.zb(1),s.gc("ngIf",!(null!=n.from&&n.from.image)),s.zb(1),s.gc("ngIf",null==n.from?null:n.from.image),s.zb(2),s.Bc(" ",n.text," "),s.zb(2),s.gc("ngIf",(null==e.usersService.session?null:e.usersService.session.id)==(null==n.from?null:n.from.id)),s.zb(1),s.Bc(" ",s.dc(10,7,n.date,"HH:mm")," ")}}const x=function(){return{standalone:!0}};let y=(()=>{class n{constructor(n,t,e,i,r,c,s){this.router=n,this.route=t,this.messagesService=e,this.usersService=i,this.ss=r,this.socketService=c,this.eventService=s,this.messages=[],this.input="",this.routerSubscription=this.router.events.subscribe(n=>{n instanceof o.b&&(this.messages=[],this.getData())})}ngOnInit(){this.socketService.onMessage.subscribe(n=>{var t,e,o;(null===(t=n.from)||void 0===t?void 0:t.id)===(null===(e=this.getTo())||void 0===e?void 0:e.id)&&(this.messagesPush([n]),this.messagesService.read(null===(o=n.from)||void 0===o?void 0:o.id).subscribe(()=>{this.eventService.onRead.next({to:null==n?void 0:n.to})}))}),this.eventService.onMessage.subscribe(n=>{var t,e;(null===(t=n.to)||void 0===t?void 0:t.id)===(null===(e=this.getTo())||void 0===e?void 0:e.id)&&this.messagesPush([n])}),this.socketService.onTyping.subscribe(n=>{var t,e,o;(null===(t=n.from)||void 0===t?void 0:t.id)===(null===(e=this.getTo())||void 0===e?void 0:e.id)&&(null===(o=this.getTo())||void 0===o||o.setTyping(1===n.typing?new Date:void 0))}),this.socketService.onRead.subscribe(n=>{var t,e;(null===(t=n.from)||void 0===t?void 0:t.id)===(null===(e=this.getTo())||void 0===e?void 0:e.id)&&this.messages.forEach(t=>{var e,o;(null===(e=n.from)||void 0===e?void 0:e.id)===(null===(o=t.from)||void 0===o?void 0:o.id)&&(t.read=!0)})})}getData(){const t=this.route.snapshot.paramMap.get("id");this.messagesService.getDetail(t).subscribe(e=>{n.to=Object(c.a)(r.a,e.to),this.messagesPush(e.messages.map(n=>Object(c.a)(i.a,n)),!0),this.messagesService.read(t).subscribe(()=>{this.eventService.onRead.next({to:this.getTo()})})})}send(){const n=this.route.snapshot.paramMap.get("id");this.input.trim().length>1&&(this.messagesService.add(n,this.input).subscribe(n=>{this.eventService.onMessage.next(Object(c.a)(i.a,n))}),this.input="")}sortMessages(){this.messages=this.messages.sort((n,t)=>{var e,o,i,r;return(null===(e=n.date)||void 0===e?void 0:e.getTime())>(null===(o=t.date)||void 0===o?void 0:o.getTime())?1:(null===(i=n.date)||void 0===i?void 0:i.getTime())<(null===(r=t.date)||void 0===r?void 0:r.getTime())?-1:0})}getTo(){return n.to}getOther(n){var t,e;return(null===(t=this.usersService.session)||void 0===t?void 0:t.id)===(null===(e=n.from)||void 0===e?void 0:e.id)?n.to:n.from}onInput(){this.socketService.socket.emit("typing",{to:this.getTo(),typing:this.input.length>0?1:0})}scrollToBottom(n=!1){var t;if(this.scrollContent){const e=null===(t=this.scrollContent)||void 0===t?void 0:t.nativeElement;(e.scrollHeight-e.scrollTop===e.clientHeight||n)&&setTimeout(()=>{e.scrollTop=e.scrollHeight-e.clientHeight})}}messagesPush(n,t){this.messages=this.messages.concat(n),this.sortMessages(),this.scrollToBottom(t)}ngOnDestroy(){this.routerSubscription.unsubscribe(),setTimeout(()=>{n.to=void 0})}}return n.\u0275fac=function(t){return new(t||n)(s.Kb(o.c),s.Kb(o.a),s.Kb(a.a),s.Kb(l.a),s.Kb(g.a),s.Kb(d.a),s.Kb(m.a))},n.\u0275cmp=s.Eb({type:n,selectors:[["app-chat"]],viewQuery:function(n,t){if(1&n&&s.Dc(O,!0),2&n){let n;s.mc(n=s.Xb())&&(t.scrollContent=n.first)}},decls:37,vars:11,consts:[[1,"container"],[1,"header"],[1,"circle-avatar"],[3,"ngIf"],["alt","",3,"src",4,"ngIf"],[1,"central"],[1,"name"],[1,"username"],["class","animate-typing",4,"ngIf"],[1,"actions"],[1,"mdi","mdi-phone"],[1,"mdi","mdi-video"],[1,"mdi","mdi-dots-vertical"],[1,"chat-container"],[1,"scroll"],["scrollContent",""],[1,"items"],["class","item",3,"ngClass",4,"ngFor","ngForOf"],[3,"ngSubmit"],[1,"input-wrapper"],[1,"microphone"],[1,"mdi","mdi-microphone-outline"],["type","text","placeholder","Type your message....",3,"ngModel","ngModelOptions","input","ngModelChange"],[1,"paperclip"],[1,"mdi","mdi-paperclip"],[1,"image"],[1,"mdi","mdi-image-outline"],[1,"submit"],[1,"mdi","mdi-send"],["alt","",3,"src"],[1,"animate-typing"],[1,"dot"],[1,"item",3,"ngClass"],[1,"item-wrapper"],[1,"text-wrapper"],[1,"time"],["class","mdi mdi-check-all",3,"ngClass",4,"ngIf"],[1,"mdi","mdi-check-all",3,"ngClass"]],template:function(n,t){if(1&n&&(s.Pb(0,"div",0),s.Pb(1,"div",1),s.Pb(2,"div",2),s.xc(3,P,1,1,"ng-template",3),s.xc(4,C,1,1,"img",4),s.Ob(),s.Pb(5,"div",5),s.Pb(6,"div",6),s.zc(7),s.Ob(),s.Pb(8,"div",7),s.zc(9),s.xc(10,M,4,0,"span",8),s.Ob(),s.Ob(),s.Pb(11,"ul",9),s.Pb(12,"li"),s.Pb(13,"a"),s.Lb(14,"i",10),s.Ob(),s.Ob(),s.Pb(15,"li"),s.Pb(16,"a"),s.Lb(17,"i",11),s.Ob(),s.Ob(),s.Pb(18,"li"),s.Pb(19,"a"),s.Lb(20,"i",12),s.Ob(),s.Ob(),s.Ob(),s.Ob(),s.Pb(21,"div",13),s.Pb(22,"div",14,15),s.Pb(24,"div",16),s.xc(25,w,11,12,"div",17),s.Ob(),s.Ob(),s.Ob(),s.Pb(26,"form",18),s.Wb("ngSubmit",function(){return t.send()}),s.Pb(27,"div",19),s.Pb(28,"button",20),s.Lb(29,"i",21),s.Ob(),s.Pb(30,"input",22),s.Wb("input",function(){return t.onInput()})("ngModelChange",function(n){return t.input=n}),s.Ob(),s.Pb(31,"button",23),s.Lb(32,"i",24),s.Ob(),s.Pb(33,"button",25),s.Lb(34,"i",26),s.Ob(),s.Ob(),s.Pb(35,"button",27),s.Lb(36,"i",28),s.Ob(),s.Ob(),s.Ob()),2&n){let n=null,e=null,o=null,i=null,r=null,c=null;s.zb(2),s.Ab("data-first-chars",null==(n=t.getTo())?null:n.firstChar()),s.zb(1),s.gc("ngIf",!(null!=(e=t.getTo())&&e.image)),s.zb(1),s.gc("ngIf",null==(o=t.getTo())?null:o.image),s.zb(3),s.Cc("",null==(i=t.getTo())?null:i.firstName," ",null==(i=t.getTo())?null:i.lastName,""),s.zb(2),s.Bc(" ",null==(r=t.getTo())?null:r.username," "),s.zb(1),s.gc("ngIf",null==(c=t.getTo())?null:c.isTyping()),s.zb(15),s.gc("ngForOf",t.messages),s.zb(5),s.gc("ngModel",t.input)("ngModelOptions",s.jc(10,x))}},directives:[u.l,u.k,h.j,h.g,h.h,h.a,h.f,h.i,u.j],pipes:[u.e],styles:["[_nghost-%COMP%]{background-color:var(--bg-color-1)}[_nghost-%COMP%], [_nghost-%COMP%]   .container[_ngcontent-%COMP%]{display:flex;flex-direction:column;height:100%}[_nghost-%COMP%]   .container[_ngcontent-%COMP%]{width:100%}[_nghost-%COMP%]   .container[_ngcontent-%COMP%]   .header[_ngcontent-%COMP%]{display:flex;flex-direction:row;align-items:center;padding:1rem 1.5rem;border-bottom:1px solid var(--color-5)}[_nghost-%COMP%]   .container[_ngcontent-%COMP%]   .header[_ngcontent-%COMP%]   .circle-avatar[_ngcontent-%COMP%]{display:flex;justify-content:center;align-items:center;border-radius:50%;width:2.5rem;height:2.5rem;flex-shrink:0}[_nghost-%COMP%]   .container[_ngcontent-%COMP%]   .header[_ngcontent-%COMP%]   .circle-avatar[_ngcontent-%COMP%]   img[_ngcontent-%COMP%]{width:100%;height:100%;object-fit:cover;border-radius:50%}[_nghost-%COMP%]   .container[_ngcontent-%COMP%]   .header[_ngcontent-%COMP%]   .central[_ngcontent-%COMP%]{display:flex;flex-direction:column;margin-left:.75rem}[_nghost-%COMP%]   .container[_ngcontent-%COMP%]   .header[_ngcontent-%COMP%]   .central[_ngcontent-%COMP%]   .name[_ngcontent-%COMP%]{font-size:.875rem;line-height:1.25rem;font-weight:600;color:var(--color-1)}[_nghost-%COMP%]   .container[_ngcontent-%COMP%]   .header[_ngcontent-%COMP%]   .central[_ngcontent-%COMP%]   .username[_ngcontent-%COMP%]{font-size:.75rem;line-height:1.5rem;color:var(--color-3)}[_nghost-%COMP%]   .container[_ngcontent-%COMP%]   .header[_ngcontent-%COMP%]   ul.actions[_ngcontent-%COMP%]{display:flex;flex-direction:row;align-items:center;margin-left:auto}[_nghost-%COMP%]   .container[_ngcontent-%COMP%]   .header[_ngcontent-%COMP%]   ul.actions[_ngcontent-%COMP%]   li[_ngcontent-%COMP%]{margin-left:.5rem}[_nghost-%COMP%]   .container[_ngcontent-%COMP%]   .header[_ngcontent-%COMP%]   ul.actions[_ngcontent-%COMP%]   li[_ngcontent-%COMP%]   a[_ngcontent-%COMP%]{display:flex;align-items:center;justify-content:center;width:2.5rem;height:2.5rem;border-radius:50%;background-color:var(--bg-color-3);color:var(--color-4)}[_nghost-%COMP%]   .container[_ngcontent-%COMP%]   .header[_ngcontent-%COMP%]   ul.actions[_ngcontent-%COMP%]   li[_ngcontent-%COMP%]   a[_ngcontent-%COMP%]:hover{background-color:var(--bg-color-4)}[_nghost-%COMP%]   .container[_ngcontent-%COMP%]   .header[_ngcontent-%COMP%]   ul.actions[_ngcontent-%COMP%]   li[_ngcontent-%COMP%]   a[_ngcontent-%COMP%]   i[_ngcontent-%COMP%]{font-size:1.25rem;line-height:1.75rem}[_nghost-%COMP%]   .container[_ngcontent-%COMP%]   .chat-container[_ngcontent-%COMP%]{height:100%;overflow:hidden}[_nghost-%COMP%]   .container[_ngcontent-%COMP%]   .chat-container[_ngcontent-%COMP%]   .scroll[_ngcontent-%COMP%]{height:100%;overflow-y:auto}[_nghost-%COMP%]   .container[_ngcontent-%COMP%]   .chat-container[_ngcontent-%COMP%]   .scroll[_ngcontent-%COMP%]   .items[_ngcontent-%COMP%]{display:grid;grid-template-columns:repeat(12,minmax(0,1fr));grid-gap:.5rem}[_nghost-%COMP%]   .container[_ngcontent-%COMP%]   .chat-container[_ngcontent-%COMP%]   .scroll[_ngcontent-%COMP%]   .items[_ngcontent-%COMP%]   .item[_ngcontent-%COMP%]{grid-column-start:1;grid-column-end:8;padding:.75rem;border-radius:.5rem}[_nghost-%COMP%]   .container[_ngcontent-%COMP%]   .chat-container[_ngcontent-%COMP%]   .scroll[_ngcontent-%COMP%]   .items[_ngcontent-%COMP%]   .item[_ngcontent-%COMP%]   .item-wrapper[_ngcontent-%COMP%]{display:flex;align-items:center;flex-direction:row}[_nghost-%COMP%]   .container[_ngcontent-%COMP%]   .chat-container[_ngcontent-%COMP%]   .scroll[_ngcontent-%COMP%]   .items[_ngcontent-%COMP%]   .item[_ngcontent-%COMP%]   .item-wrapper[_ngcontent-%COMP%]   .circle-avatar[_ngcontent-%COMP%]{display:flex;justify-content:center;align-items:center;border-radius:50%;width:2.5rem;height:2.5rem;flex-shrink:0}[_nghost-%COMP%]   .container[_ngcontent-%COMP%]   .chat-container[_ngcontent-%COMP%]   .scroll[_ngcontent-%COMP%]   .items[_ngcontent-%COMP%]   .item[_ngcontent-%COMP%]   .item-wrapper[_ngcontent-%COMP%]   .circle-avatar[_ngcontent-%COMP%]   img[_ngcontent-%COMP%]{width:100%;height:100%;object-fit:cover;border-radius:50%}[_nghost-%COMP%]   .container[_ngcontent-%COMP%]   .chat-container[_ngcontent-%COMP%]   .scroll[_ngcontent-%COMP%]   .items[_ngcontent-%COMP%]   .item[_ngcontent-%COMP%]   .item-wrapper[_ngcontent-%COMP%]   .text-wrapper[_ngcontent-%COMP%]{position:relative;padding:.5rem 2.75rem .5rem 1rem;margin-left:.75rem;font-size:.875rem;line-height:1.25rem;border-radius:.75rem;background-color:var(--bg-color-chat-item);color:var(--color-1);box-shadow:0 0 0 0 transparent,0 0 0 0 transparent,0 1px 3px 0 rgba(0,0,0,.1),0 1px 2px 0 rgba(0,0,0,.06)}[_nghost-%COMP%]   .container[_ngcontent-%COMP%]   .chat-container[_ngcontent-%COMP%]   .scroll[_ngcontent-%COMP%]   .items[_ngcontent-%COMP%]   .item[_ngcontent-%COMP%]   .item-wrapper[_ngcontent-%COMP%]   .text-wrapper[_ngcontent-%COMP%]   .time[_ngcontent-%COMP%]{position:absolute;bottom:.25rem;right:.25rem;font-size:.75rem;line-height:1rem;color:var(--color-4)}[_nghost-%COMP%]   .container[_ngcontent-%COMP%]   .chat-container[_ngcontent-%COMP%]   .scroll[_ngcontent-%COMP%]   .items[_ngcontent-%COMP%]   .item.me[_ngcontent-%COMP%]{grid-column-start:6;grid-column-end:13}[_nghost-%COMP%]   .container[_ngcontent-%COMP%]   .chat-container[_ngcontent-%COMP%]   .scroll[_ngcontent-%COMP%]   .items[_ngcontent-%COMP%]   .item.me[_ngcontent-%COMP%]   .item-wrapper[_ngcontent-%COMP%]{justify-content:flex-start!important;flex-direction:row-reverse}[_nghost-%COMP%]   .container[_ngcontent-%COMP%]   .chat-container[_ngcontent-%COMP%]   .scroll[_ngcontent-%COMP%]   .items[_ngcontent-%COMP%]   .item.me[_ngcontent-%COMP%]   .item-wrapper[_ngcontent-%COMP%]   .text-wrapper[_ngcontent-%COMP%]{padding-right:4rem;margin-left:0;margin-right:.75rem;background-color:var(--bg-color-chat-item-me)}[_nghost-%COMP%]   .container[_ngcontent-%COMP%]   .chat-container[_ngcontent-%COMP%]   .scroll[_ngcontent-%COMP%]   .items[_ngcontent-%COMP%]   .item.me[_ngcontent-%COMP%]   .item-wrapper[_ngcontent-%COMP%]   .text-wrapper[_ngcontent-%COMP%]   .time[_ngcontent-%COMP%]{bottom:0;right:.5rem}[_nghost-%COMP%]   .container[_ngcontent-%COMP%]   .chat-container[_ngcontent-%COMP%]   .scroll[_ngcontent-%COMP%]   .items[_ngcontent-%COMP%]   .item.me[_ngcontent-%COMP%]   .item-wrapper[_ngcontent-%COMP%]   .text-wrapper[_ngcontent-%COMP%]   .time[_ngcontent-%COMP%]   i[_ngcontent-%COMP%]{font-size:1rem;line-height:1.5rem;color:var(--color-4)}[_nghost-%COMP%]   .container[_ngcontent-%COMP%]   .chat-container[_ngcontent-%COMP%]   .scroll[_ngcontent-%COMP%]   .items[_ngcontent-%COMP%]   .item.me[_ngcontent-%COMP%]   .item-wrapper[_ngcontent-%COMP%]   .text-wrapper[_ngcontent-%COMP%]   .time[_ngcontent-%COMP%]   i.read[_ngcontent-%COMP%]{color:#2563eb}[_nghost-%COMP%]   .container[_ngcontent-%COMP%]   form[_ngcontent-%COMP%]{display:flex;flex-direction:row;align-items:center;padding-bottom:.5rem}[_nghost-%COMP%]   .container[_ngcontent-%COMP%]   form[_ngcontent-%COMP%]   .input-wrapper[_ngcontent-%COMP%]{display:flex;flex-direction:row;align-items:center;width:100%;height:3rem;margin-left:.5rem;border:1px solid var(--color-5);border-radius:1.5rem;background-color:var(--bg-color-chat-item)}[_nghost-%COMP%]   .container[_ngcontent-%COMP%]   form[_ngcontent-%COMP%]   .input-wrapper[_ngcontent-%COMP%]   button[_ngcontent-%COMP%]{width:3rem;height:3rem;z-index:1;outline:transparent}[_nghost-%COMP%]   .container[_ngcontent-%COMP%]   form[_ngcontent-%COMP%]   .input-wrapper[_ngcontent-%COMP%]   button[_ngcontent-%COMP%]   i[_ngcontent-%COMP%]{font-size:1.5rem;line-height:2rem;color:var(--color-4)}[_nghost-%COMP%]   .container[_ngcontent-%COMP%]   form[_ngcontent-%COMP%]   .input-wrapper[_ngcontent-%COMP%]   input[_ngcontent-%COMP%]{width:100%;height:100%;margin-left:-3rem;padding-left:3rem;margin-right:-6rem;padding-right:6rem;border-radius:1.5rem;outline:transparent;background-color:initial;color:var(--color-1)}[_nghost-%COMP%]   .container[_ngcontent-%COMP%]   form[_ngcontent-%COMP%]   button.submit[_ngcontent-%COMP%]{width:3rem;height:3rem;margin:0 .75rem;outline:transparent;color:var(--color-1);border-radius:50%;background-color:var(--bg-color-5);flex-shrink:0}[_nghost-%COMP%]   .container[_ngcontent-%COMP%]   form[_ngcontent-%COMP%]   button.submit[_ngcontent-%COMP%]   i[_ngcontent-%COMP%]{font-size:1.5rem;line-height:2rem}"]}),n})()},TdLt:function(n,t,e){"use strict";e.r(t),e.d(t,"MessagesModule",function(){return I});var o=e("ofXK"),i=e("tyNb"),r=e("/pI1"),c=e("LGct"),s=e("Oqma"),a=e("fXoL"),l=e("OlZr"),g=e("56ro"),d=e("caAo"),m=e("yFR0"),u=e("6BoG"),h=e("3Pt+");function O(n,t){if(1&n&&a.zc(0),2&n){const n=a.ac(2).$implicit,t=a.ac();let e=null;a.Ac(null==(e=t.getOther(n))?null:e.nameShort())}}function P(n,t){if(1&n&&a.Lb(0,"img",19),2&n){const n=a.ac(2).$implicit,t=a.ac();let e=null;a.gc("src",t.ss.API_IMAGE_PREFIX+(null==(e=t.getOther(n))?null:e.image),a.pc)}}function C(n,t){1&n&&(a.Pb(0,"span",20),a.Lb(1,"span",21),a.Lb(2,"span",21),a.Lb(3,"span",21),a.Ob())}const M=function(n){return{read:n}};function _(n,t){if(1&n&&a.Lb(0,"i",22),2&n){const n=a.ac(2).$implicit;a.gc("ngClass",a.kc(1,M,n.read))}}function b(n,t){if(1&n&&(a.Pb(0,"div",23),a.zc(1),a.Ob()),2&n){const n=a.ac(2).$implicit;a.zb(1),a.Bc(" ",null==n?null:n.unReadCount," ")}}const p=function(n){return[n]};function f(n,t){if(1&n&&(a.Pb(0,"a",9),a.Pb(1,"div",10),a.zc(2),a.bc(3,"date"),a.Ob(),a.Pb(4,"div",11),a.xc(5,O,1,1,"ng-template",12),a.xc(6,P,1,1,"ng-template",12),a.Ob(),a.Pb(7,"div",13),a.Pb(8,"div",14),a.zc(9),a.xc(10,C,4,0,"span",15),a.Ob(),a.Pb(11,"div",16),a.xc(12,_,1,3,"i",17),a.zc(13),a.Ob(),a.Ob(),a.xc(14,b,2,1,"div",18),a.Ob()),2&n){const n=a.ac().$implicit,t=a.ac();let e=null,o=null,i=null,r=null,c=null,s=null;a.gc("routerLink",a.kc(14,p,""+(null==(e=t.getOther(n))?null:e.id))),a.zb(2),a.Ac(a.dc(3,11,n.date,"EEE HH:mm")),a.zb(2),a.Ab("data-first-chars",null==(o=t.getOther(n))?null:o.firstChar()),a.zb(1),a.gc("ngIf",!(null!=(i=t.getOther(n))&&i.image)),a.zb(1),a.gc("ngIf",null==(r=t.getOther(n))?null:r.image),a.zb(3),a.Cc(" ",null==(c=t.getOther(n))?null:c.firstName," ",null==(c=t.getOther(n))?null:c.lastName," "),a.zb(1),a.gc("ngIf",null==(s=t.getOther(n))?null:s.isTyping()),a.zb(2),a.gc("ngIf",(null==n||null==n.from?null:n.from.id)===(null==t.usersService||null==t.usersService.session?null:t.usersService.session.id)),a.zb(1),a.Bc(" ",n.text," "),a.zb(1),a.gc("ngIf",null==n?null:n.unReadCount)}}function v(n,t){if(1&n&&a.xc(0,f,15,16,"a",8),2&n){const n=t.$implicit,e=a.ac();a.gc("ngIf",e.filterByInput(n))}}const w=function(){return{standalone:!0}},x=[{path:"",component:(()=>{class n{constructor(n,t,e,o,i,r){this.ss=n,this.messagesService=t,this.usersService=e,this.router=o,this.socketService=i,this.eventService=r,this.messages=[],this.input=""}ngOnInit(){this.messagesService.getGroupList().subscribe(n=>{this.messages=n.map(n=>Object(c.a)(r.a,n)),this.sortMessages()}),this.socketService.onTyping.subscribe(n=>{this.messages.forEach(t=>{var e;const o=this.getOther(t);(null===(e=n.from)||void 0===e?void 0:e.id)===(null==o?void 0:o.id)&&(null==o||o.setTyping(1===n.typing?new Date:void 0))})}),this.socketService.onRead.subscribe(n=>{this.messages.forEach(t=>{var e;const o=this.getOther(t);(null===(e=n.from)||void 0===e?void 0:e.id)===(null==o?void 0:o.id)&&(t.read=!0)})}),this.eventService.onRead.subscribe(n=>{this.messages.forEach(t=>{var e;const o=this.getOther(t);(null===(e=null==n?void 0:n.to)||void 0===e?void 0:e.id)===(null==o?void 0:o.id)&&(t.unReadCount=0)})}),this.eventService.onMessage.subscribe(n=>{let t=!1;this.messages=this.messages.map(e=>{var o;const i=this.getOther(e);return(null===(o=n.to)||void 0===o?void 0:o.id)===(null==i?void 0:i.id)?(t=!0,n.unReadCount=e.unReadCount,n):e}),t||this.messages.push(n),this.sortMessages()}),this.socketService.onMessage.subscribe(n=>{let t=!1;this.messages=this.messages.map(e=>{var o,i;const r=this.getOther(e);return(null==r?void 0:r.id)===(null===(o=n.from)||void 0===o?void 0:o.id)?(t=!0,(null===(i=s.a.to)||void 0===i?void 0:i.id)!==(null==r?void 0:r.id)&&(n.unReadCount=e.unReadCount?e.unReadCount+1:1),n):e}),t||this.messages.push(n),this.sortMessages()})}sortMessages(){this.messages=this.messages.sort((n,t)=>{var e,o,i,r;return(null===(e=n.date)||void 0===e?void 0:e.getTime())>(null===(o=t.date)||void 0===o?void 0:o.getTime())?-1:(null===(i=n.date)||void 0===i?void 0:i.getTime())<(null===(r=t.date)||void 0===r?void 0:r.getTime())?1:0})}getOther(n){var t,e;return(null===(t=this.usersService.session)||void 0===t?void 0:t.id)===(null===(e=n.from)||void 0===e?void 0:e.id)?n.to:n.from}filterByInput(n){var t,e;const o=this.getOther(n),i=((null==o?void 0:o.firstName)+" "+(null==o?void 0:o.lastName)).toLocaleLowerCase("tr-TR");return 0===this.input.length||-1!==i.indexOf(this.input)||-1!==(null===(t=null==o?void 0:o.username)||void 0===t?void 0:t.indexOf(this.input))||-1!==(null===(e=null==n?void 0:n.text)||void 0===e?void 0:e.indexOf(this.input))}}return n.\u0275fac=function(t){return new(t||n)(a.Kb(l.a),a.Kb(g.a),a.Kb(d.a),a.Kb(i.c),a.Kb(m.a),a.Kb(u.a))},n.\u0275cmp=a.Eb({type:n,selectors:[["app-messages"]],decls:10,vars:4,consts:[[1,"content"],[1,"input-wrapper"],[1,"mdi","mdi-magnify"],["placeholder","Search","autocomplete","off",3,"ngModel","ngModelOptions","ngModelChange"],[1,"group-label"],[1,"items"],["ngFor","",3,"ngForOf"],[1,"router-area"],["routerLinkActive","active",3,"routerLink",4,"ngIf"],["routerLinkActive","active",3,"routerLink"],[1,"time"],[1,"circle-avatar"],[3,"ngIf"],[1,"central"],[1,"name"],["class","animate-typing",4,"ngIf"],[1,"text"],["class","mdi mdi-check-all",3,"ngClass",4,"ngIf"],["class","counter",4,"ngIf"],["alt","",3,"src"],[1,"animate-typing"],[1,"dot"],[1,"mdi","mdi-check-all",3,"ngClass"],[1,"counter"]],template:function(n,t){1&n&&(a.Pb(0,"div",0),a.Pb(1,"div",1),a.Lb(2,"i",2),a.Pb(3,"input",3),a.Wb("ngModelChange",function(n){return t.input=n}),a.Ob(),a.Ob(),a.Pb(4,"div",4),a.zc(5,"TEAM"),a.Ob(),a.Pb(6,"div",5),a.xc(7,v,1,1,"ng-template",6),a.Ob(),a.Ob(),a.Pb(8,"div",7),a.Lb(9,"router-outlet"),a.Ob()),2&n&&(a.zb(3),a.gc("ngModel",t.input)("ngModelOptions",a.jc(3,w)),a.zb(4),a.gc("ngForOf",t.messages))},directives:[h.a,h.f,h.i,o.k,i.g,o.l,i.e,i.d,o.j],pipes:[o.e],styles:["[_nghost-%COMP%]{background-color:var(--bg-color-1);flex-direction:row!important}[_nghost-%COMP%]   .content[_ngcontent-%COMP%]{display:flex;flex-direction:column;width:24rem;height:100%;padding:1rem;background-color:var(--bg-color-2);overflow-x:auto}[_nghost-%COMP%]   .content[_ngcontent-%COMP%]   .input-wrapper[_ngcontent-%COMP%]{display:flex;flex-direction:row}[_nghost-%COMP%]   .content[_ngcontent-%COMP%]   .input-wrapper[_ngcontent-%COMP%]   i[_ngcontent-%COMP%]{width:2.5rem;text-align:center;padding-left:.25rem;font-size:1.125rem;line-height:1.75rem;color:var(--color-4);z-index:1;display:flex;justify-content:center;align-items:center}[_nghost-%COMP%]   .content[_ngcontent-%COMP%]   .input-wrapper[_ngcontent-%COMP%]   input[_ngcontent-%COMP%]{width:100%;padding:.5rem .75rem .5rem 2.5rem;margin-left:-2.5rem;border-style:none;border-radius:.5rem;background-color:var(--bg-color-3);color:var(--color-1);outline:0}[_nghost-%COMP%]   .content[_ngcontent-%COMP%]   .group-label[_ngcontent-%COMP%]{margin-top:1.25rem;color:var(--color-4);font-size:.75rem;line-height:1rem;font-weight:600}[_nghost-%COMP%]   .content[_ngcontent-%COMP%]   .items[_ngcontent-%COMP%]{display:flex;flex-direction:column;margin-top:.5rem;margin-left:-1rem}[_nghost-%COMP%]   .content[_ngcontent-%COMP%]   .items[_ngcontent-%COMP%] > a[_ngcontent-%COMP%]{display:flex;flex-direction:row;align-items:center;padding:1rem 0 1rem 1rem;position:relative}[_nghost-%COMP%]   .content[_ngcontent-%COMP%]   .items[_ngcontent-%COMP%] > a.active[_ngcontent-%COMP%]{border-left-width:2px;border-color:#ef4444;--tw-gradient-to:transparent;--tw-gradient-from:var(--color-4);--tw-gradient-stops:var(--tw-gradient-from),var(--tw-gradient-to,rgba(254,226,226,0));background-image:linear-gradient(90deg,var(--tw-gradient-stops))}[_nghost-%COMP%]   .content[_ngcontent-%COMP%]   .items[_ngcontent-%COMP%] > a[_ngcontent-%COMP%]   .time[_ngcontent-%COMP%]{position:absolute;right:0;top:0;margin-top:.75rem;color:var(--color-3);font-size:.75rem;line-height:1rem}[_nghost-%COMP%]   .content[_ngcontent-%COMP%]   .items[_ngcontent-%COMP%] > a[_ngcontent-%COMP%]   .circle-avatar[_ngcontent-%COMP%]{display:flex;justify-content:center;align-items:center;border-radius:50%;width:2.5rem;height:2.5rem}[_nghost-%COMP%]   .content[_ngcontent-%COMP%]   .items[_ngcontent-%COMP%] > a[_ngcontent-%COMP%]   .circle-avatar[_ngcontent-%COMP%]   img[_ngcontent-%COMP%]{width:100%;height:100%;object-fit:cover;border-radius:50%}[_nghost-%COMP%]   .content[_ngcontent-%COMP%]   .items[_ngcontent-%COMP%] > a[_ngcontent-%COMP%]   .central[_ngcontent-%COMP%]{display:flex;flex-direction:column;flex:1;margin-left:.5rem;color:var(--color-1);overflow:hidden;text-overflow:ellipsis;white-space:nowrap}[_nghost-%COMP%]   .content[_ngcontent-%COMP%]   .items[_ngcontent-%COMP%] > a[_ngcontent-%COMP%]   .central[_ngcontent-%COMP%]   .name[_ngcontent-%COMP%]{font-size:.875rem;line-height:1.25rem;font-weight:500;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}[_nghost-%COMP%]   .content[_ngcontent-%COMP%]   .items[_ngcontent-%COMP%] > a[_ngcontent-%COMP%]   .central[_ngcontent-%COMP%]   .text[_ngcontent-%COMP%]{overflow:hidden;text-overflow:ellipsis;white-space:nowrap;font-size:.75rem;line-height:1.5rem}[_nghost-%COMP%]   .content[_ngcontent-%COMP%]   .items[_ngcontent-%COMP%] > a[_ngcontent-%COMP%]   .central[_ngcontent-%COMP%]   .text[_ngcontent-%COMP%]   i[_ngcontent-%COMP%]{font-size:1rem;line-height:1.5rem;color:var(--color-4)}[_nghost-%COMP%]   .content[_ngcontent-%COMP%]   .items[_ngcontent-%COMP%] > a[_ngcontent-%COMP%]   .central[_ngcontent-%COMP%]   .text[_ngcontent-%COMP%]   i.read[_ngcontent-%COMP%]{color:#2563eb}[_nghost-%COMP%]   .content[_ngcontent-%COMP%]   .items[_ngcontent-%COMP%] > a[_ngcontent-%COMP%]   .counter[_ngcontent-%COMP%]{display:flex;align-items:center;justify-content:center;align-self:flex-end;width:1.25rem;height:1.25rem;font-size:.75rem;line-height:1rem;border-radius:50%;background-color:#ef4444;color:#fff}[_nghost-%COMP%]   .router-area[_ngcontent-%COMP%]{display:flex;flex-direction:row;height:100%;width:100%;flex:1;background-image:url(/dist/undraw_reminders_697p.1733a2bb71f59b53f83c.svg);background-repeat:no-repeat;background-position:50%;background-size:80% 80%}"]}),n})(),children:[{path:":id",loadChildren:()=>e.e(6).then(e.bind(null,"h3Z1")).then(n=>n.ChatModule)}]}];let y=(()=>{class n{}return n.\u0275mod=a.Ib({type:n}),n.\u0275inj=a.Hb({factory:function(t){return new(t||n)},imports:[[i.f.forChild(x)],i.f]}),n})();var z=e("MutI"),k=e("FKr1");e("8LU1"),e("cH1L");let T=(()=>{class n{}return n.\u0275mod=a.Ib({type:n}),n.\u0275inj=a.Hb({factory:function(t){return new(t||n)},imports:[[k.d,k.b],k.d,k.b]}),n})(),I=(()=>{class n{}return n.\u0275mod=a.Ib({type:n}),n.\u0275inj=a.Hb({factory:function(t){return new(t||n)},imports:[[o.c,y,z.a,T,h.c]]}),n})()}}]);