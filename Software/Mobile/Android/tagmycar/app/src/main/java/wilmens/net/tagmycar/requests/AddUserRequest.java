package wilmens.net.tagmycar.requests;

import android.app.Activity;

import org.json.JSONException;
import org.json.JSONObject;

import java.lang.reflect.Method;
import java.util.List;

import wilmens.net.tagmycar.objects.ServerResponseEnum;
import wilmens.net.tagmycar.responses.AddUserResponse;
import wilmens.net.tagmycar.responses.Response;

/**
 * Created by Will on 1/10/15.
 */
public class AddUserRequest extends Request{
    AddUserResponse response;

    public AddUserRequest(Activity requestingPage) {
        super(requestingPage);
    }

    @Override
    protected void buildRequest(List<RequestParameter> params) {
        super.buildRequest("AddUserRequest", params);
    }

    @Override
    protected void handleResponse(Object result) throws JSONException {
        response = new AddUserResponse();
        Response retval = (Response)result;
        response.result = retval.result;
        response.success = retval.success;

        if (retval.success){
            if (retval.result == ServerResponseEnum.OK){
                response.success = true;
            }else{
                JSONObject json = new JSONObject(retval.data);
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

    public AddUserResponse getResponse(){
        return this.response;
    }
}
