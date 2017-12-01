class Principal extends Context{
    onStart(){
        //if(!this.animationStarted){
        eventosManager.lockEvento = new AnimationLock();
        eventosManager.inicializarListaPrincipal();
        noticiasManager.lockNoticia = new AnimationLock();
        noticiasManager.inicializarNoticiasPrincipal();
        this.plantillaEventoModal = contextManager.contextList["eventos"].plantillaEventoModal;
        this.plantillaNoticiaModal = contextManager.contextList["noticias"].plantillaNoticiaModal;
        //    this.animationStarted = true;
        //}
    }
    onStop(){
        noticiasManager.lockNoticia.stopAnimation();
        eventosManager.lockEvento.stopAnimation();
    }
}
class AcercaDe extends Context{
    constructor(menuElement){
        super(menuElement);
        this.cont = this.context.querySelector("#contenido-ad");
        this.subSections = this.getSubSections();
        this.actual = this.subSections["aiu-espacioscw"];
    }
    getSubSections(){
        var elements = {};

        elements["aiu-espacioscw"] = this.getSubSection("aiu-espacioscw");
        elements["aiu-cafe"] = this.getSubSection("aiu-cafe");
        elements["aiu-espaciosev"] = this.getSubSection("aiu-espaciosev");
        elements["aiu-salareuniones"] = this.getSubSection("aiu-salareuniones");
        elements["aiu-aceleradora"] = this.getSubSection("aiu-aceleradora");
        return elements;
    }
    getSubSection(id){
        var node = document.createElement("div");
        node.appendChild(document.importNode(this.context.querySelector("#"+id).content,true));
        console.log(node);
        return node;
    }
    onStart(){
        this.cont = document.getElementById("contenido-ad");
        this.cont.innerHTML = this.actual.innerHTML;
        this.slide = new ArticleSlide("lista-general");
        this.slide.start();
    }
    onStop(){
        this.slide.stop();
    }
    cambiarSubseccion(id){
        this.slide.stop();
        this.actual = this.subSections[id];
        this.cont = document.getElementById("contenido-ad");
        this.cont.innerHTML = this.actual.innerHTML;
        if((id == "aiu-espacioscw")||(id == "aiu-salareuniones")){
            this.slide = new ArticleSlide("lista-general");
            this.slide.start();
        }
        else{
            this.slide.stop();
        }
    }
}
class Membresia extends Context{
    onStart(){

    }
    onStop(){

    }
}
class Eventos extends Context{
    constructor(menuElement){
        super(menuElement);
        var plantilla = this.context.querySelector("#evento-modal").content;
        this.plantillaEventoModal = document.createElement("div");
        this.plantillaEventoModal.appendChild(document.importNode(plantilla,true));
    }
    onStart(){
        eventosManager.inicializar();
    }
    onStop(){

    }
}
class Comunidad extends Context{
    onStart(){

    }
    onStop(){

    }
}
class StartupChile extends Context{
    constructor(menuElement){
        super(menuElement);
        this.slider = new ArticleSlide("lista-startup");
    }
    onStart(){
        this.slider.start();

    }
    onStop(){
        this.slider.stop();
    }
}
class Noticias extends Context{
    constructor(menuElement){
        super(menuElement);
        var plantilla = this.context.querySelector("#noticia-modal").content;
        this.plantillaNoticiaModal = document.createElement("div");
        this.plantillaNoticiaModal.appendChild(document.importNode(plantilla,true));
    }
    onStart(){
        noticiasManager.inicializar();
    }
    onStop(){

    }
}
class Visita extends Context{
    constructor(menuElement){
        super(menuElement);
    }
    onStart(){
        var mapContainer = init();
        var mapCover = document.createElement("div");
        mapCover.style="top:0px;"
        mapContainer.appendChild(mapCover);
    }
    onStop(){

    }
}
class ContextManager extends ContextManagerBase{
    getContextFromTemplate(el){
        var contexto = null;
        var tId = el.attributes.templateId.value;
        if(tId == "principal") contexto = new Principal(el);
        else if(tId == "acercade") contexto = new AcercaDe(el);
        else if(tId == "membresia") contexto = new Membresia(el);
        else if(tId == "eventos") contexto = new Eventos(el);
        else if(tId == "comunidad") contexto = new Comunidad(el);
        else if(tId == "startupchile") contexto = new StartupChile(el);
        else if(tId == "noticias") contexto = new Noticias(el);
        else if(tId == "visita") contexto = new Visita(el);
        return contexto;
    }
}
