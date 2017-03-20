/*
This file is generated and isn't the actual source code for this
managed global class.
This read-only file shows the class's global constructors,
methods, variables, and properties.
To enable code to compile, all methods return null.
*/
global class Sage_COR_Message {
    global String Message {
        get;
        set;
    }
    global s2cor.Sage_COR_Message.Sage_COR_Message_Severity Severity {
        get;
        set;
    }
    global Sage_COR_Message(s2cor.Sage_COR_Message.Sage_COR_Message_Severity p_severity, String p_message) {

    }
global enum Sage_COR_Message_Severity {CONFIRM, ERROR, FATAL, INFO, WARNING}
}
