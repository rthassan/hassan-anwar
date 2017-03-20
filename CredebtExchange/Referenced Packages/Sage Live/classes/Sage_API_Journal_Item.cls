/*
This file is generated and isn't the actual source code for this
managed global class.
This read-only file shows the class's global constructors,
methods, variables, and properties.
To enable code to compile, all methods return null.
*/
global class Sage_API_Journal_Item {
    global Double Amount {
        get;
        set;
    }
    global Boolean IsCredit {
        get;
        set;
    }
    global Datetime ItemDate {
        get;
        set;
    }
    global List<s2cor.Sage_API_Journal_Item> Items {
        get;
        set;
    }
    global String ItemTextualReference {
        get;
        set;
    }
    global s2cor.Sage_API_Reference Reference {
        get;
        set;
    }
    global List<s2cor.Sage_API_Tag> Tags {
        get;
        set;
    }
    global String Type {
        get;
        set;
    }
    global Sage_API_Journal_Item() {

    }
    global Sage_API_Journal_Item(s2cor.Sage_API_Reference p_reference, String p_type, Double p_amount, List<s2cor.Sage_API_Tag> p_tags, List<s2cor.Sage_API_Journal_Item> p_items) {

    }
}
