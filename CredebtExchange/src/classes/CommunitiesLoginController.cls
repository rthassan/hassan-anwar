global with sharing class CommunitiesLoginController {
	 public String password { get; set; }
	 public String username { get; set; }
	 global CommunitiesLoginController () {}

	 global PageReference forwardToAuthPage() {
    	String startUrl = System.currentPageReference().getParameters().get('startURL');
    	String displayType = System.currentPageReference().getParameters().get('display');
        return Network.forwardToAuthPage(startUrl, displayType);
     }

	 global PageReference RedirectToLogin() {
         return new PageReference( '/CredebtLoginPage');
	 }

	 public PageReference loginUser() {
         return Site.login(username, password,'/ApplicationLanding');
	 }
    
     public PageReference forgotpassword() {
         return new PageReference('/secur/forgotpassword.jsp?locale=us&lqs=');
	 }
    
     public PageReference sflogin() {
         return new PageReference('https://credebt--rtdev2.cs88.my.salesforce.com/?ec=302&startURL=%2F%2Fservlet%2Fnetworks%2Fsession%2Fcreate%3Fsite%3D0DM0Y000000D1Jh%26refURL%3Dhttp%253A%252F%252Frtdev2-credebt.cs88.force.com%252FcredebtCommunity%252Flogin%26inst%3D9E');
	 }
}