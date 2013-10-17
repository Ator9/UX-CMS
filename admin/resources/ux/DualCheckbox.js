/**
 * DualCheckbox plugin - checkbox with on/off values
 *
 * @author Sebastián Gasparri
 * @version 11/05/2013 21:06:32
 *
 * Usage: 
 * 1: Ext.create('Admin.extjs.DualCheckbox', { name: 'superuser', fieldLabel: 'Superuser' });
 * 2: { name: 'superuser', fieldLabel: 'Superuser', xtype: 'dualcheckbox', inputValue: '1',  inputValueOff: '0' }
 * 
 */
 
Ext.define('Ext.ux.DualCheckbox', {
    extend: 'Ext.form.Checkbox',
    alias: 'widget.dualcheckbox',

    inputValue: 'Y', // Value when checkbox is cheched
    inputValueOff: 'N', // Value when checkbox is unchecked

    initComponent: function() {
        this.callParent();
    },

    onRender: function() {
        this.form = this.findParentByType('form').getForm();
        this.callParent();
    },
    
    listeners: {
        change: function(field, newValue, oldValue, eOpts) {
            var param = {}; // Start object
            param[this.name] = this.inputValueOff; // Add param
            this.form.baseParams = param;
        }
    }
});
