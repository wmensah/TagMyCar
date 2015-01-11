package wilmens.net.tagmycar.objects;

import org.json.JSONException;
import org.json.JSONObject;

import java.text.ParseException;

/**
 * Created by Will on 1/10/15.
 */
public interface IWebserviceJSONObject {
    public Object loadFromJson(JSONObject data) throws JSONException, ParseException;
}
