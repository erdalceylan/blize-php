(window.webpackJsonp=window.webpackJsonp||[]).push([[7],{RmqX:function(n,t,e){"use strict";e.r(t),e.d(t,"SearchModule",function(){return _});var o=e("ofXK"),c=e("tyNb"),r=e("LGct"),i=e("0xcB"),s=e("fXoL"),a=e("caAo"),g=e("OlZr"),l=e("3Pt+");function u(n,t){if(1&n&&s.zc(0),2&n){const n=s.ac().$implicit;s.Ac(null==n?null:n.nameShort())}}function O(n,t){if(1&n&&s.Lb(0,"img",11),2&n){const n=s.ac().$implicit,t=s.ac();s.gc("src",t.ss.API_IMAGE_PREFIX+(null==n?null:n.image),s.pc)}}function P(n,t){if(1&n&&(s.Pb(0,"a",7),s.Pb(1,"div",8),s.xc(2,u,1,1,"ng-template",9),s.xc(3,O,1,1,"ng-template",9),s.Ob(),s.Pb(4,"div",10),s.Pb(5,"span"),s.zc(6),s.Ob(),s.Pb(7,"small"),s.zc(8),s.Ob(),s.Ob(),s.Ob()),2&n){const n=t.$implicit;s.ic("routerLink","/messages/",n.id,""),s.zb(1),s.Ab("data-first-chars",null==n?null:n.firstChar()),s.zb(1),s.gc("ngIf",!(null!=n&&n.image)),s.zb(1),s.gc("ngIf",null==n?null:n.image),s.zb(3),s.Cc("",n.firstName," ",n.lastName,""),s.zb(2),s.Bc("@",n.username,"")}}const m=function(){return{standalone:!0}},M=[{path:"",component:(()=>{class n{constructor(n,t){this.usersService=n,this.ss=t,this.users=[],this.input=""}ngOnInit(){this.usersService.search().subscribe(n=>{this.users=n.map(n=>Object(r.a)(i.a,n))})}}return n.\u0275fac=function(t){return new(t||n)(s.Kb(a.a),s.Kb(g.a))},n.\u0275cmp=s.Eb({type:n,selectors:[["app-search"]],decls:7,vars:4,consts:[[1,"container"],[1,"content"],[1,"input-wrapper"],[1,"mdi","mdi-magnify"],["placeholder","Search","autocomplete","off",3,"ngModel","ngModelOptions","ngModelChange"],[1,"users"],["ngFor","",3,"ngForOf"],[1,"user",3,"routerLink"],[1,"circle-avatar"],[3,"ngIf"],[1,"info"],["alt","",3,"src"]],template:function(n,t){1&n&&(s.Pb(0,"div",0),s.Pb(1,"div",1),s.Pb(2,"div",2),s.Lb(3,"i",3),s.Pb(4,"input",4),s.Wb("ngModelChange",function(n){return t.input=n}),s.Ob(),s.Ob(),s.Pb(5,"div",5),s.xc(6,P,9,7,"ng-template",6),s.Ob(),s.Ob(),s.Ob()),2&n&&(s.zb(4),s.gc("ngModel",t.input)("ngModelOptions",s.jc(3,m)),s.zb(2),s.gc("ngForOf",t.users))},directives:[l.a,l.f,l.i,o.k,c.e,o.l],styles:["[_nghost-%COMP%]{overflow-x:auto;height:auto!important;min-height:100%;background-color:var(--bg-color-2)}[_nghost-%COMP%]   .container[_ngcontent-%COMP%]{max-width:none;display:flex;justify-content:center}[_nghost-%COMP%]   .container[_ngcontent-%COMP%]   .content[_ngcontent-%COMP%]{display:flex;flex-direction:column;max-width:36rem;width:100%;margin-top:4rem}[_nghost-%COMP%]   .container[_ngcontent-%COMP%]   .content[_ngcontent-%COMP%]   .input-wrapper[_ngcontent-%COMP%]{display:flex;flex-direction:row}[_nghost-%COMP%]   .container[_ngcontent-%COMP%]   .content[_ngcontent-%COMP%]   .input-wrapper[_ngcontent-%COMP%]   i[_ngcontent-%COMP%]{width:2.5rem;text-align:center;padding-left:.25rem;font-size:1.125rem;line-height:1.75rem;color:var(--color-4);z-index:1;display:flex;justify-content:center;align-items:center}[_nghost-%COMP%]   .container[_ngcontent-%COMP%]   .content[_ngcontent-%COMP%]   .input-wrapper[_ngcontent-%COMP%]   input[_ngcontent-%COMP%]{width:100%;padding:.5rem .75rem .5rem 2.5rem;margin-left:-2.5rem;border-style:none;border-radius:.5rem;background-color:var(--bg-color-3);color:var(--color-1);outline:0}[_nghost-%COMP%]   .container[_ngcontent-%COMP%]   .content[_ngcontent-%COMP%]   .users[_ngcontent-%COMP%]{margin-top:1rem}[_nghost-%COMP%]   .container[_ngcontent-%COMP%]   .content[_ngcontent-%COMP%]   .users[_ngcontent-%COMP%]   a.user[_ngcontent-%COMP%]{display:flex;flex-direction:row;align-items:center;border-bottom:1px solid var(--color-5_5);padding:1rem;margin-left:5rem}[_nghost-%COMP%]   .container[_ngcontent-%COMP%]   .content[_ngcontent-%COMP%]   .users[_ngcontent-%COMP%]   a.user[_ngcontent-%COMP%]   .circle-avatar[_ngcontent-%COMP%]{display:flex;justify-content:center;align-items:center;border-radius:50%;width:4rem;height:4rem;margin-left:-5rem}[_nghost-%COMP%]   .container[_ngcontent-%COMP%]   .content[_ngcontent-%COMP%]   .users[_ngcontent-%COMP%]   a.user[_ngcontent-%COMP%]   .circle-avatar[_ngcontent-%COMP%]   img[_ngcontent-%COMP%]{width:100%;height:100%;object-fit:cover;border-radius:50%}[_nghost-%COMP%]   .container[_ngcontent-%COMP%]   .content[_ngcontent-%COMP%]   .users[_ngcontent-%COMP%]   a.user[_ngcontent-%COMP%]   .info[_ngcontent-%COMP%]{display:flex;flex-direction:column;margin-left:.5rem}[_nghost-%COMP%]   .container[_ngcontent-%COMP%]   .content[_ngcontent-%COMP%]   .users[_ngcontent-%COMP%]   a.user[_ngcontent-%COMP%]   .info[_ngcontent-%COMP%]   span[_ngcontent-%COMP%]{font-size:1.125rem;line-height:1.75rem;font-weight:700;color:var(--color-1)}[_nghost-%COMP%]   .container[_ngcontent-%COMP%]   .content[_ngcontent-%COMP%]   .users[_ngcontent-%COMP%]   a.user[_ngcontent-%COMP%]   .info[_ngcontent-%COMP%]   small[_ngcontent-%COMP%]{font-size:1.125rem;line-height:1.75rem;color:var(--color-3)}"]}),n})()}];let C=(()=>{class n{}return n.\u0275mod=s.Ib({type:n}),n.\u0275inj=s.Hb({factory:function(t){return new(t||n)},imports:[[c.f.forChild(M)],c.f]}),n})(),_=(()=>{class n{}return n.\u0275mod=s.Ib({type:n}),n.\u0275inj=s.Hb({factory:function(t){return new(t||n)},imports:[[o.c,l.c,C]]}),n})()}}]);