/*
This file is generated and isn't the actual source code for this
managed global class.
This read-only file shows the class's global constructors,
methods, variables, and properties.
To enable code to compile, all methods return null.
*/
global class Sage_API_Journal {
    global String Description {
        get;
        set;
    }
    global List<s2cor.Sage_API_Journal_Item> Items {
        get;
        set;
    }
    global s2cor.Sage_API_Reference JournalCompany {
        get;
        set;
    }
    global s2cor.Sage_API_Reference JournalCurrency {
        get;
        set;
    }
    global Datetime JournalDate {
        get;
        set;
    }
    global Decimal JournalExchangeRate {
        get;
        set;
    }
    global String JournalTextualReference {
        get;
        set;
    }
    global s2cor.Sage_API_Reference JournalType {
        get;
        set;
    }
    global s2cor.Sage_API_Enums_OperationType Operation {
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
    global Sage_API_Journal() {

    }
    global Sage_API_Journal(s2cor.Sage_API_Reference p_reference, List<s2cor.Sage_API_Tag> p_tags, List<s2cor.Sage_API_Journal_Item> p_items, s2cor.Sage_API_Enums_OperationType p_operation, s2cor.Sage_API_Reference p_company, s2cor.Sage_API_Reference p_currency, s2cor.Sage_API_Reference p_type, Datetime p_date) {

    }
}
