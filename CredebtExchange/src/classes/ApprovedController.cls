public class ApprovedController {
    
    Account originator;
    
    public ApprovedController(ApplicationProcess obj)
    {
        this.originator = obj.originator;
    }
    
    public Account getOriginator() {
        return originator;
    }
    
}