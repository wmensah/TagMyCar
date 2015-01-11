package wilmens.net.tagmycar.objects;

import org.json.JSONException;
import org.json.JSONObject;

import java.text.DateFormat;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.Locale;

/**
 * Created by Will on 1/10/15.
 */
public class User implements IWebserviceJSONObject{

    private int userId;
    private String primaryTag;
    private String mobileDeviceId;
    private Date joinDateUtc;
    private Date termDateUtc;

    public int getUserId() {
        return userId;
    }

    public void setUserId(int userId) {
        this.userId = userId;
    }

    public String getPrimaryTag() {
        return primaryTag;
    }

    public void setPrimaryTag(String primaryTag) {
        this.primaryTag = primaryTag;
    }

    public String getMobileDeviceId() {
        return mobileDeviceId;
    }

    public void setMobileDeviceId(String mobileDeviceId) {
        this.mobileDeviceId = mobileDeviceId;
    }

    public Date getJoinDateUtc() {
        return joinDateUtc;
    }

    public void setJoinDateUtc(Date joinDateUtc) {
        this.joinDateUtc = joinDateUtc;
    }

    public Date getTermDateUtc() {
        return termDateUtc;
    }

    public void setTermDateUtc(Date termDateUtc) {
        this.termDateUtc = termDateUtc;
    }

    public User loadFromJson(JSONObject data) throws JSONException, ParseException{
        DateFormat formatter = new SimpleDateFormat("yyyy-MM-dd hh:mm:ss", Locale.ENGLISH);

        User user = new User();
        user.userId  = data.getInt("id");
        user.primaryTag = data.getString("tag");
        user.mobileDeviceId = data.getString("mobile_device_id");

        // dates
        user.joinDateUtc = formatter.parse(data.getString("join_date_utc"));
        user.termDateUtc = formatter.parse(data.getString("term_date_utc"));

        return user;
    }

}
