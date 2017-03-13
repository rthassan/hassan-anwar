@isTest
public class sumUpReferralsTest {
	@isTest public static void testReferralCount() {
     	Account referee = new Account(Name = 'Referee');
        insert referee;
        
        Account referral = new Account(Name = 'Referral',
            	Referrer_c__c = referee.Id
        );
        insert referral; // This will fire the trigger we are testing.
        
        referee = [SELECT Id, Referred_Organisations__c FROM Account WHERE Id = :referee.Id];
        System.assertEquals(1, referee.Referred_Organisations__c);
    }
}