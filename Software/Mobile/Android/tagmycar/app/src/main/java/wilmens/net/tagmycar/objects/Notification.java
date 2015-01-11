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
public class Notification implements IWebserviceJSONObject {

    private int id;
    private NotificationType notificationType;
    private User sentFromUser;
    private User sentToUser;
    private Date sentDateUtc;
    private Date receivedDateUtc;
    private boolean acknowledged;
    private Date acknowledgedDateUtc;

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public NotificationType getNotificationType() {
        return notificationType;
    }

    public void setNotificationType(NotificationType notificationType) {
        this.notificationType = notificationType;
    }

    public User getSentFromUser() {
        return sentFromUser;
    }

    public void setSentFromUser(User sentFromUser) {
        this.sentFromUser = sentFromUser;
    }

    public User getSentToUser() {
        return sentToUser;
    }

    public void setSentToUser(User sentToUser) {
        this.sentToUser = sentToUser;
    }

    public Date getSentDateUtc() {
        return sentDateUtc;
    }

    public void setSentDateUtc(Date sentDateUtc) {
        this.sentDateUtc = sentDateUtc;
    }

    public Date getReceivedDateUtc() {
        return receivedDateUtc;
    }

    public void setReceivedDateUtc(Date receivedDateUtc) {
        this.receivedDateUtc = receivedDateUtc;
    }

    public boolean isAcknowledged() {
        return acknowledged;
    }

    public void setAcknowledged(boolean acknowledged) {
        this.acknowledged = acknowledged;
    }

    public Date getAcknowledgedDateUtc() {
        return acknowledgedDateUtc;
    }

    public void setAcknowledgedDateUtc(Date acknowledgedDateUtc) {
        this.acknowledgedDateUtc = acknowledgedDateUtc;
    }

    @Override
    public Notification loadFromJson(JSONObject data) throws JSONException, ParseException {

        DateFormat formatter = new SimpleDateFormat("yyyy-MM-dd hh:mm:ss", Locale.ENGLISH);

        Notification notif = new Notification();
        notif.id  = data.getInt("id");

        notif.notificationType = new NotificationType();
        notif.notificationType.loadFromJson(data.getJSONObject("notification_type"));

        notif.sentFromUser = new User();
        notif.sentFromUser.loadFromJson(data.getJSONObject("sent_from_user"));

        notif.sentToUser = new User();
        notif.sentToUser.loadFromJson(data.getJSONObject("sent_to_user"));

        // dates
        notif.sentDateUtc = formatter.parse(data.getString("sent_date_utc"));
        notif.receivedDateUtc = formatter.parse(data.getString("received_date_utc"));

        notif.acknowledged = data.getBoolean("acknowledged");
        notif.acknowledgedDateUtc = formatter.parse(data.getString("received_date_utc"));

        return notif;
    }
}
