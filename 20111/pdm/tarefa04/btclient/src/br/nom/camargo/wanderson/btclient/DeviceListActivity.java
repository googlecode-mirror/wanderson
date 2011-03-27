package br.nom.camargo.wanderson.btclient;

import java.util.Set;

import android.app.ListActivity;
import android.bluetooth.BluetoothAdapter;
import android.bluetooth.BluetoothDevice;
import android.content.Context;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.TextView;

public class DeviceListActivity extends ListActivity
{
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        DeviceListAdapter adapter = new DeviceListAdapter(this, R.layout.devicerow);
        setListAdapter(adapter);
        BluetoothAdapter radio = BluetoothAdapter.getDefaultAdapter();
        Set<BluetoothDevice> paired = radio.getBondedDevices();
        for (BluetoothDevice d : paired) {
            adapter.add(d);
        }
    }

    private class DeviceListAdapter extends ArrayAdapter<BluetoothDevice>
    {
        public DeviceListAdapter(Context context, int view)
        {
            super(context, view);
        }
        public View getView(int position, View convert, ViewGroup parent)
        {
            LayoutInflater li = (LayoutInflater) getSystemService(Context.LAYOUT_INFLATER_SERVICE);
            convert = li.inflate(R.layout.devicerow, null);
            BluetoothDevice device = getItem(position);
            TextView name = (TextView) convert.findViewById(R.id.device_name);
            TextView addr = (TextView) convert.findViewById(R.id.device_address);
            name.setText(device.getName());
            addr.setText(device.getAddress());
            return convert;
        }
    }
}
