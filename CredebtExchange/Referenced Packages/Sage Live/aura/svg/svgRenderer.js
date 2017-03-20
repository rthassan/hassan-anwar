({
    render: function(component, helper) {
        //grab attributes from the component markup
        var classname = component.get("v.class");
        var xlinkhref = component.get("v.xlinkhref");
        var ariaHidden = component.get("v.ariahidden");
        
        //return an svg element w/ the attributes
        var svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
        svg.setAttribute('class', classname);
        svg.setAttribute('aria-hidden', ariaHidden);
        svg.innerHTML = '<use xlink:href="'+xlinkhref+'"></use>';
        return svg;
    }
})