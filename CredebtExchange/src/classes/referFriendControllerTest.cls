@isTest
public class referFriendControllerTest {
    
    @isTest static void testMethod1(){
        
        PageReference pageRef = Page.referFriend;
        Test.setCurrentPage(pageref);
        
        referFriendController con = new referFriendController();
        
        con.save();
    }
    

}