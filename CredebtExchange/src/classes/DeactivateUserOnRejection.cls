public class DeactivateUserOnRejection {
	@future
     public static void DeactivateUser(string acctid) {
         User[] users = [select Name, IsActive from User where Originator_Id__c = :acctid and IsActive = true];
          for (User u : users) {
              u.IsActive = false;
              update u;
          }
     }
}