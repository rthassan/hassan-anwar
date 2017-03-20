/**
 * Created by daniel.colquhoun on 10/10/2016.
 */
({
    substituteActionParam : function (component, param) {
        if (param.indexOf('{') !== -1)
        {
            // Placeholder string found. Find and replace.
            var regex = /{([\w\d]+)}/g;
            var match = regex.exec(param);
            while (match != null) {
                param = param.replace('{'+match[1]+'}', component.get(match[1]));
                match = regex.exec(param);
            }
        }
        return param;
    },

})