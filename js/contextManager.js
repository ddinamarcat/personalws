class Context{
    constructor(menuElement){
        this.menuElement = menuElement;
        var templateId = menuElement.attributes.templateId.value;
        this.contextId = templateId;
        this.context = document.createElement("section");
        var template = document.getElementById(templateId);
        this.setContextByTemplate(template);
        this.removeTemplateNode(template);
        this.lock = false;
        this.animationStarted = false;
    }
    setContextByTemplate(template){
        this.context.appendChild(document.importNode(template.content,true));
    }
    removeTemplateNode(template){
        var parent = template.parentElement;
        parent.removeChild(template);
    }
    //stub method for implementing the interface
    onStart(){}
    //stub method for implementing the interface
    onStop(){}
}
class ContextManagerBase {
    constructor(containerId){
        this.cont = document.getElementById(containerId); //the node that will contain the context info
        this.defaultContext = "principal";
        this.defaultContextMark = 0;
        this.actualClass = "actual";
        this.noActualClass = "no-actual";
        this.actual = " "; //actual context
        this.actualMenuElement = null;
        this.lock = false;
        this.animationTime = 400;
        this.activatedClassName = "c-activado"; //used to apply a css animation to the incoming context
        this.deactivatedClassName = "c-desactivado"; //used to apply a css animation to the context going out
        this.noMenuElements = null;
        this.contextList = {};
        //Array of main menu elements
        this.mMenu = null;
        //get and initialize all of the main menu elements
        this.setMainMenuElements();
        this.prepareMainMenu();
        this.prepareContexts();
        var hashL = window.location.hash;
        var newHashL = this.defaultContext;
        if(hashL.length > 0) newHashL = hashL.substring(1);
        this.changeHash(newHashL,1);
        this.menuM = document.getElementById("top-menu");
        var cm = this;
        window.onhashchange = function(){
            var hashL = window.location.hash;
            if(hashL.length > 0) cm.changeContext(hashL.substring(1),1);
        }
    }
    //stub method for implementing the interface
    getContextFromTemplate(el){}
    prepareContexts(){
        var elems = this.mMenu;
        var t = elems.length;
        var contexto = null;
        for(var i=0;i<t;i++){
            contexto = this.getContextFromTemplate(elems[i]);
            this.registerContext(contexto);
        }
    }
    registerContext(context){
        this.contextList[context.contextId] = context;
    }

    changeMark(contextId,mark){
        if(mark == 0){
            if(this.actualMenuElement != null){
                    this.actualMenuElement.classList.remove(this.actualClass);
                    this.actualMenuElement.classList.add(this.noActualClass);
            }
        }
        else{
            if(this.actualMenuElement != null){
                    this.actualMenuElement.classList.remove(this.actualClass);
                    this.actualMenuElement.classList.add(this.noActualClass);
            }
            var temp = document.getElementById(contextId);
            temp.classList.remove(this.noActualClass);
            temp.classList.add(this.actualClass);
            this.actualMenuElement = temp;
        }
    }
    prepareMainMenu(){
        var cMenu = this.mMenu;
        var tElems = cMenu.length;
        for(var i=0; i<tElems; i++){
            cMenu[i].id = "m"+cMenu[i].attributes.templateid.value;
        }
        this.setOnClickListeners(cMenu);
    }
    setMainMenuElements(){
        this.mMenu = document.getElementsByClassName("main-menu-element");
    }
    setOnClickListeners(eList){
        var cm = this;
        var tElems = eList.length;
        var alink = null;
        var el = null;
        for(var i=0; i<tElems; i++){
            var el = eList[i];
            if(el.nodeName.toLowerCase() == "a"){
                el.href = "#"+el.attributes.templateId.value;
            }
            else{
                alink = el.querySelector("a");
                if(alink != null){
                    alink.href = "#"+el.attributes.templateId.value;
                }
                el.addEventListener("click",function(){
                        cm.changeHash(this.attributes.templateId.value,this.attributes.mark.value);
                        if(cm.menuM.classList.contains("menum-activo")){
                            cm.menuM.classList.remove("menum-activo");
                            cm.menuM.classList.add("menum-inactivo");
                        }
                        }
                    );

            }

        }
    }
    setNoMenuElements(){
        this.noMenuElements = document.getElementsByClassName("context-changer");
    }
    updateNoMenuElements(){
        this.setNoMenuElements();
        this.setOnClickListeners(this.noMenuElements);
    }
    changeContext(contextId,mark){
        var cm=this, c=cm.cont, ccl=c.classList, acn=cm.activatedClassName, dcn=cm.deactivatedClassName;
        var tcId = contextId;
        var context = cm.contextList[contextId];
        var previo = cm.actualMenuElement;
        if(cm.lock == true) return false;
        cm.changeMark("m"+contextId,mark);
        ccl.remove(acn);
        ccl.add(dcn);
        cm.lock = true;
        window.setTimeout(function(){
            if(previo){
                cm.contextList[previo.attributes.templateId.value].onStop();
                window.scrollTo(0,0);
            }
            c.innerHTML = context.context.innerHTML;
            context.onStart();
            ccl.remove(dcn);
            ccl.add(acn);
            cm.lock = false;
            cm.updateNoMenuElements();
        },cm.animationTime);
        return true;
    }
    changeHash(contextId,mark){
        var hashL = window.location.hash;
        if(((hashL.substring(1) != contextId) && (this.lock == false))||(this.cont.children.length == 0)){
            history.pushState(null,"","#"+contextId);
            this.changeContext(contextId,mark);
            return true;
        }
        return false;
    }
}
class AnimationLock{
    constructor(){
        this.lock = 1;
    }
    stopAnimation(){
        this.lock = 0;
    }
}
