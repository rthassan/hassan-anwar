/**
 * Created by daniel.colquhoun on 07/12/2016.
 */
({


    doInit:function(component,event,helper){

            var value = component.get('v.value');
            var type = component.get('v.type');
            var decimalPlaces = component.get('v.decimalPlaces');
            var prefix = component.get('v.prefix');

            var attributes = {};

            switch(type) {
                case 'date':
                case 'datetime':

    // dc notes implement below in Data_Field component
    // AFFIXME date locale information is being ignored by the formattedDateTime component and the code below!
    // Bug reported to John Belo 21st Sep 2016
    //                var dateFormat = $A.get("$Locale.dateFormat");
    //                var userLocaleLang = $A.get("$Locale.langLocale");
    //                var formattedDate =  $A.localizationService.formatDate(value, dateFormat, userLocaleLang);
    //                var dt = Date.parse(formattedDate);


                    if (value != undefined && value != null && value != '') {
                        var dt;
                        if (type == 'date') {
                            dt = helper.getDateValueFromISODate(value);
                        } else {
                            dt = Date.parse(value);
                        }

                        if (component.get('v.dt') == null) {
                            component.set('v.dt', dt);
                        }


                            helper.createOutput(component, 'lightning:formattedDateTime', dt, attributes, prefix);

                    }
                    break;

                case 'currency':
                    attributes = {
                        style: "currency",
                        currencyCode: prefix
                    };
                    prefix = '';
                    //don't break here
                case 'number':
                case 'percentage':
                    attributes['minimumFractionDigits'] = decimalPlaces;
                    attributes['maximumFractionDigits'] = decimalPlaces;
                    helper.createOutput(component, 'lightning:formattedNumber', value, attributes, prefix);
                    break;

                case 'boolean':
                    value = value ? $A.get("$Label.s2cor.Yes") : '';
                    // don't break here
                default:
                    helper.createOutput(component, 'ui:outputText', value, attributes, prefix);
                    break;
            }
         }
})