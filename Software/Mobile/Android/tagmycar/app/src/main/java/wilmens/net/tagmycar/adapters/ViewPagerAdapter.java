package wilmens.net.tagmycar.adapters;

import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentPagerAdapter;

import wilmens.net.tagmycar.fragments.ReceivedNotificationsFragment;
import wilmens.net.tagmycar.fragments.SendNotificationFragment;
import wilmens.net.tagmycar.fragments.SentNotificationsFragment;

/**
 * Created by Will on 1/11/15.
 */
public class ViewPagerAdapter extends FragmentPagerAdapter{

    public ViewPagerAdapter(FragmentManager fm) {
        super(fm);
    }

    @Override
    public Fragment getItem(int position) {
        Fragment fragment = null;
        if (position == 0){
            fragment = new SendNotificationFragment();
        }
        else if (position == 1){
            fragment = new ReceivedNotificationsFragment();
        }
        else if (position == 2){
            fragment = new SentNotificationsFragment();
        }
        return fragment;
    }

    @Override
    public int getCount() {
        return 3;
    }
}
