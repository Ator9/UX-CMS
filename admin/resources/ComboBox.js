/**
 * ComboboxPlus plugin - combobox with extra features
 *
 * @author Sebastián Gasparri
 * http://www.linkedin.com/in/sgasparri
 *
 * Usage:
 * 1: Ext.create('Ext.ux.ComboBox', { name: 'adminID', valueField: 'adminID', displayField: 'username', store: Ext.create('store').load() });
 * 2: { xtype: 'comboboxplus', name: 'adminID', valueField: 'adminID', displayField: 'username', store: Ext.create('store').load() }
 *
 */

Ext.define('Ext.ux.ComboBox', {
    extend: 'Ext.form.ComboBox',
    alias: 'widget.comboboxplus',

    width: 250,
    emptyText: Admin.t('Select') + '...',
    queryMode: 'local', // 'remote' is typically used for "autocomplete" type inputs.
    forceSelection: true, // true to restrict the selected value to one of the values in the list, false to allow the user to set arbitrary text into the field.

    triggers: {
        clear: {
            cls: 'x-form-clear-trigger',
            weight: -1,
            handler: function(obj) {
                this.clearValue();
                delete(this.up().up().store.getProxy().extraParams[obj.name]);
                this.up().up().store.reload(); // Reload
            }
        }
    },

    listeners: {
        select: {
            fn: function(combo, records, eOpts) {
                this.up().up().store.getProxy().extraParams[combo.name] = combo.getValue(); // Add extra param
                this.up().up().store.reload(); // Reload
            }
        }
    }
});
