package wilmens.net.tagmycar.objects;

import org.json.JSONException;
import org.json.JSONObject;

import java.text.DateFormat;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Locale;

/**
 * Created by Will on 1/10/15.
 */
public class NotificationType implements IWebserviceJSONObject{
    private int id;
    private String name;
    private String description;

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getDescription() {
        return description;
    }

    public void setDescription(String description) {
        this.description = description;
    }

    @Override
    public NotificationType loadFromJson(JSONObject data) throws JSONException, ParseException {

        NotificationType nt = new NotificationType();
        nt.id  = data.getInt("id");
        nt.name = data.getString("name");
        nt.description = data.getString("description");

        return nt;
    }
}
