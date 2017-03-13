public class RecentContactsController {
    private List<Contact> recentContacts;
    
    public List<Contact> getRecentContacts()
    {
        recentContacts= [SELECT Name, Title, Email, Phone
                FROM Contact
                WHERE LastViewedDate != NULL 
                ORDER BY LastViewedDate DESC Limit 10];
        
       
        return recentContacts;
      
     }
    
}