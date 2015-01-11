package wilmens.net.tagmycar.requests;

import android.app.Activity;

import org.json.JSONException;

import java.lang.reflect.Method;
import java.util.List;

import wilmens.net.tagmycar.responses.GetNotificationsResponse;

/**
 * Created by Will on 1/10/15.
 */
public class GetNotificationsRequest extends Request {

    GetNotificationsResponse response;

    public GetNotificationsRequest(Activity requestingPage) {
        super(requestingPage);
    }

    @Override
    protected void buildRequest(List<RequestParameter> params) {
        super.buildRequest("GetNotificationsRequest", params);
    }

    @Override
    protected void handleResponse(Object result) throws JSONException {

    }

    @Override
    public void setResponseHandler(Method responseHandler) {
        this.responseHandler = responseHandler;
    }

    public GetNotificationsResponse getResponse() {
        return response;
    }
}
