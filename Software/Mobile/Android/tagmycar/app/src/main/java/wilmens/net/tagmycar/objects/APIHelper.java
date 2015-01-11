package wilmens.net.tagmycar.objects;

/**
 * Created by Will on 1/10/15.
 */
public class APIHelper {

    private static String WEBSERVICE_ROOT_URL = "http://localhost/tagmycar/index.php/api/bumper/";
    private static String APIKey = "123"; // not used yet
    public static String getWebserviceUrl(){
        return WEBSERVICE_ROOT_URL + "key/" + APIKey + "/";
    }
}
