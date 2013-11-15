/**
 * DualCheckbox plugin - checkbox with on/off values
 *
 * @author Sebastián Gasparri
 * @version 20/10/2013 20:30:48
 *
 * Usage: 
 * 1: Ext.create('Admin.extjs.DualCheckbox', { name: 'superuser', fieldLabel: 'Superuser' });
 * 2: { xtype: 'dualcheckbox', name: 'superuser', fieldLabel: 'Superuser', inputValue: '1',  inputValueOff: '0' }
 * 
 */
 
Ext.define('Ext.ux.DualCheckbox', {
    extend: 'Ext.form.Checkbox',
    alias: 'widget.dualcheckbox',

    inputValue: 'Y', // Value when checkbox is cheched
    inputValueOff: 'N', // Value when checkbox is unchecked

    initComponent: function() {
        this.callParent(arguments);
    },

    onRender: function() {
        this.form = this.findParentByType('form').getForm();
        
        if(!this.form.baseParams) this.form.baseParams = {}; // Start object if not exists
        this.form.baseParams[this.name] = this.inputValueOff; // Add off param
        
        this.callParent(arguments);
    },
    
    listeners: {
        change: function(field, newValue, oldValue, eOpts) {
            this.form.baseParams[this.name] = this.inputValueOff; // Add off param
        }
    }
});
