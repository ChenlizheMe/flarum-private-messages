import app from 'flarum/admin/app';
import { getChenlizheMePrivateMessagesDefaultColors } from '../admin-forum-common';

app.initializers.add('chenlizheme-private-messages', () => {
  app.extensionData
    .for('chenlizheme-private-messages')
    .registerSetting({
      setting: 'chenlizheme-private-messages.return_key',
      type: 'bool',
      label: app.translator.trans('chenlizheme-private-messages.admin.settings.return_key'),
      help: app.translator.trans('chenlizheme-private-messages.admin.settings.return_key_help')
    })
    // .registerSetting({
    //   setting: 'chenlizheme-private-messages.show_read_receipts',
    //   type: 'bool',
    //   label: app.translator.trans('chenlizheme-private-messages.admin.settings.show_read_receipts'),
    //   help: app.translator.trans('chenlizheme-private-messages.admin.settings.show_read_receipts_help')
    // })
    .registerSetting(function () {
      const initialInstalledVersion = this.setting('chenlizheme-private-messages.initial_installed_version')();

      const defaultColors = getChenlizheMePrivateMessagesDefaultColors(initialInstalledVersion);

      const enableCustomColorsSetting = this.setting('chenlizheme-private-messages.enable_custom_colors');
      const senderBackgroundColorSetting = this.setting('chenlizheme-private-messages.sender_background_color');
      const recipientBackgroundColorSetting = this.setting('chenlizheme-private-messages.recipient_background_color');
      const senderTextColorSetting = this.setting('chenlizheme-private-messages.sender_text_color');
      const recipientTextColorSetting = this.setting('chenlizheme-private-messages.recipient_text_color');

      const enableCustomColors = enableCustomColorsSetting() !== false && enableCustomColorsSetting() !== '0' && enableCustomColorsSetting() !== '';

      const senderBackgroundColor = (senderBackgroundColorSetting() || null) ?? defaultColors.senderBackgroundColor;
      const recipientBackgroundColor = (recipientBackgroundColorSetting() || null) ?? defaultColors.recipientBackgroundColor;

      const senderTextColor = (senderTextColorSetting() || null) ?? defaultColors.senderTextColor;
      const recipientTextColor = (recipientTextColorSetting() || null) ?? defaultColors.recipientTextColor;

      const colorInputStyle = {
        width: '5em',
        background: 'initial',
        border: 'initial'
      };

      return (
        <div className="chenlizheme-private-messages-color-settings-section" style={{ 'margin-bottom': '2em' }}>
          <h2 style={{ 'margin-bottom': '0.25em' }}>Colors</h2>

          <div style={{ display: 'flex', gap: '1em', margin: '1em 0' }}>
            <input id="chenlizheme-private-messages-enable-custom-colors" type="checkbox" checked={enableCustomColors} onchange={event => enableCustomColorsSetting(event.target.checked)} />

            <label for="chenlizheme-private-messages-enable-custom-colors">
              {app.translator.trans('chenlizheme-private-messages.admin.settings.enable_custom_colors')}
            </label>
          </div>

          <div className="chenlizheme-private-messages-color-settings" style={{ display: 'grid', 'grid-template-columns': 'auto 1fr', gap: '1em', 'align-items': 'center', color: enableCustomColors ? null : 'gray' }}>
            <label for="chenlizheme-private-messages-sender-background-color">
              {app.translator.trans('chenlizheme-private-messages.admin.settings.sender_background_color')}
            </label>
            <input id="chenlizheme-private-messages-sender-background-color" disabled={!enableCustomColors} type="color" value={senderBackgroundColor} onchange={event => senderBackgroundColorSetting(event.target.value)} style={colorInputStyle} />

            <label for="chenlizheme-private-messages-recipient-background-color">
              {app.translator.trans('chenlizheme-private-messages.admin.settings.recipient_background_color')}
            </label>
            <input id="chenlizheme-private-messages-recipient-background-color" disabled={!enableCustomColors} type="color" value={recipientBackgroundColor} onchange={event => recipientBackgroundColorSetting(event.target.value)} style={colorInputStyle} />

            <label for="chenlizheme-private-messages-sender-text-color">
              {app.translator.trans('chenlizheme-private-messages.admin.settings.sender_text_color')}
            </label>
            <input id="chenlizheme-private-messages-sender-text-color" disabled={!enableCustomColors} type="color" value={senderTextColor} onchange={event => senderTextColorSetting(event.target.value)} style={colorInputStyle} />

            <label for="chenlizheme-private-messages-recipient-text-color">
              {app.translator.trans('chenlizheme-private-messages.admin.settings.recipient_text_color')}
            </label>
            <input id="chenlizheme-private-messages-recipient-text-color" disabled={!enableCustomColors} type="color" value={recipientTextColor} onchange={event => recipientTextColorSetting(event.target.value)} style={colorInputStyle} />
          </div>
        </div >
      );
    })
    .registerPermission(
      {
        icon: 'fas fa-user-lock',
        label: app.translator.trans('chenlizheme-private-messages.admin.permissions.start_label'),
        permission: 'startConversation',
      },
      'start'
    )
    .registerPermission(
      {
        icon: 'fas fa-user-lock',
        label: app.translator.trans('chenlizheme-private-messages.admin.permissions.allow_users_to_receive_email_notifications'),
        permission: 'chenlizheme-private-messages.allowUsersToReceiveEmailNotifications',
      },
      'start'
    );
});
