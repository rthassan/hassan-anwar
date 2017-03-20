({
    upload: function(component, event, helper) {

        var files = component.find('files').getElement();

        for(var fileIndex in files.files)
        {
            var file = files.files[fileIndex];
            var filename = file.name;

            if(file.size > 0) {
                // do something with the file...

                var reader = new FileReader();

                // If we use onloadend, we need to check the readyState.
                reader.onloadend = function(evt) {
                  if (evt.target.readyState == FileReader.DONE) { // DONE == 2
                    var content = evt.target.result;

                    var testEvent = component.getEvent("fileEvent");

                    testEvent.setParams
                    ({
                        'content': content,
                        'name': file.name
                    });

                    testEvent.fire();
                  }
                };

                var blob = file.slice(0, file.size);
                reader.readAsBinaryString(blob);


            }
        }
    }
})