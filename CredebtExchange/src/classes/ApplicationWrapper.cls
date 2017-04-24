public class ApplicationWrapper {
    
    public String MType{get;set;}
    public String CompanyNumber{get;set;}
    public string CredebtorName{get;set;}
    public Decimal Amount{get;set;}
    public string Dso{get;set;}
    public string Risk{set;get;}
    public Decimal CLimit{get;set;}
    public Application_Creditor__c ac{get;set;}
    
    
    public ApplicationWrapper(string mtype,string cn,string cname,decimal amount,string dso, string risk, decimal climit)
    {
        this.mtype = mtype;
        this.companyNumber = cn;
        this.CredebtorName = cname;
        this.amount = amount;
        this.dso = dso;
        this.risk = risk;
        this.climit = climit;
        
    }
    
    public ApplicationWrapper(APplication_Creditor__c ac)
    {
        this.ac = ac;
    }
    

}