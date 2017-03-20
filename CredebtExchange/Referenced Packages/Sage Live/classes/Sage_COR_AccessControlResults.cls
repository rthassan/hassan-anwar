/*
This file is generated and isn't the actual source code for this
managed global class.
This read-only file shows the class's global constructors,
methods, variables, and properties.
To enable code to compile, all methods return null.
*/
global virtual class Sage_COR_AccessControlResults {
global class AccessControlResultsException extends Exception {
}
global class DeleteResults extends s2cor.Sage_COR_AccessControlResults {
    global DeleteResults(List<Database.DeleteResult> results) {

    }
    global List<Database.DeleteResult> getResults() {
        return null;
    }
    global Boolean wasSuccessful() {
        return null;
    }
}
global class InsertResults extends s2cor.Sage_COR_AccessControlResults {
    global InsertResults(List<SObject> objects, List<Database.SaveResult> results) {

    }
    global List<SObject> getInsertedObjects() {
        return null;
    }
    global List<Database.SaveResult> getResults() {
        return null;
    }
    global Boolean wasSuccessful() {
        return null;
    }
}
global class UpdateResults extends s2cor.Sage_COR_AccessControlResults {
    global UpdateResults(List<SObject> objects, List<Database.SaveResult> results) {

    }
    global List<Database.SaveResult> getResults() {
        return null;
    }
    global List<SObject> getUpdatedObjects() {
        return null;
    }
    global Boolean wasSuccessful() {
        return null;
    }
}
global class UpsertResults extends s2cor.Sage_COR_AccessControlResults {
    global UpsertResults(List<SObject> objects, List<Database.UpsertResult> results) {

    }
    global List<Database.UpsertResult> getResults() {
        return null;
    }
    global List<SObject> getUpsertedObjects() {
        return null;
    }
    global Boolean wasSuccessful() {
        return null;
    }
}
}
