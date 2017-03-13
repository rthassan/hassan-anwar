public class DirectorsController {
    Account originator;
    Application__c app;
    
    Contact director;
    public List<Contact> dirList {get;set;}
    Boolean isLoaded;
    Boolean isDataFilled;
    
    public DirectorsController(ApplicationProcess obj)
    {
        this.originator=obj.originator;
        this.app=obj.app;
        dirList=new List<Contact>();
        isLoaded=true;
        isDataFilled=true;
    }
    
    
    public List<Contact> getDirectorsList()
    {  
        
        Integer numOfDirectors=Integer.valueOf(originator.Number_of_Directors__c);
        
        List<Contact> existingDirectors=[Select FirstName, MailingStreet, LastName, OtherStreet, Email, MailingCity, MobilePhone,
                                         MailingPostalCode, MailingCountry from Contact where AccountId=:originator.Id and Director__c=true];
        
        if(existingDirectors.size()==numOfDirectors)
        {
            dirList=existingDirectors;
        }
        else if(isLoaded)
        {
            for(Integer i=0;i<numOfDirectors;i++)
            {
                director=new Contact(AccountId=originator.Id, Director__c=true);
                dirList.add(director);
            }
            isLoaded=false;
        }
        
        
        return dirList;
        
    }
    
    public PageReference step8() {
        
        upsert dirList;
        
        for(Contact dir:dirList)
        {
            if(dir.FirstName==null || dir.MailingStreet==null || dir.LastName==null || dir.OtherStreet==null || dir.Email==null || dir.MailingCity==null || dir.MobilePhone==null
               || dir.MailingPostalCode==null || dir.MailingCountry==null )
            {
                isDataFilled=false;
                break;
            }
        }
        
        if(isDataFilled)
        {
            app.Director_Information__c = true;
            update app;
            return Page.DirectorsPractices;
        }
        isDataFilled=true;
        return ApexPages.currentPage();
      
    }
    
    public PageReference saveAndReturn() {
        
        upsert dirList;        
        
        PageReference homePage = new PageReference('/_ui/core/chatter/ui/ChatterPage');//ApexPages.StandardController(opportunity).view();
        homePage.setRedirect(true);
        return homePage;
    }
    
    
}