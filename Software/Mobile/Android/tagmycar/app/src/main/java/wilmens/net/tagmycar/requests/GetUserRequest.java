package wilmens.net.tagmycar.requests;

import android.app.Activity;

import org.json.JSONException;
import org.json.JSONObject;

import java.lang.reflect.Method;
import java.text.ParseException;
import java.util.List;

import wilmens.net.tagmycar.objects.ServerResponseEnum;
import wilmens.net.tagmycar.objects.User;
import wilmens.net.tagmycar.responses.GetUserResponse;
import wilmens.net.tagmycar.responses.Response;

/**
 * Created by Will on 1/10/15.
 */
public class GetUserRequest extends Request {

    GetUserResponse response;

    public GetUserRequest(Activity requestingPage) {
        super(requestingPage);
    }

    @Override
    protected void buildRequest(List<RequestParameter> params) {
        super.buildRequest("GetUserRequest", params);
    }

    @Override
    protected void handleResponse(Object result) throws JSONException {
        response = new GetUserResponse();

        Response retval = (Response)result;
        response.result = retval.result;
        response.success = retval.success;

        if (retval.success){

            JSONObject json = new JSONObject(retval.data);

            if (retval.result == ServerResponseEnum.OK){
                response.success = true;
                try {
                    response.user = new User();
                    response.user.loadFromJson(json.getJSONObject("data"));
                } catch (ParseException e) {
                    e.printStackTrace();
                }
            }else{
                response.errorMessage = json.getString("status");
            }
        }else{
            response.success = false;
            response.errorMessage = retval.errorMessage;
        }
        super.doHandleResponse();
    }

    @Override
    public void setResponseHandler(Method responseHandler) {
        this.responseHandler = responseHandler;
    }

    public GetUserResponse getResponse(){
        return this.response;
    }
}
