import Modal from 'flarum/common/components/Modal';
import Button from 'flarum/common/components/Button';
import RecipientSearch from './RecipientSearch';
import username from 'flarum/common/helpers/username';
import Stream from 'flarum/common/utils/Stream';
import withAttr from 'flarum/common/utils/withAttr';
import app from 'flarum/forum/app';

export default class StartConversationModal extends Modal {
  oninit(vnode) {
    super.oninit(vnode);

    app.cache.conversationsRecipient = null;

    this.conversations = this.attrs.conversations;

    this.already = false;

    this.messageContent = Stream('');
  }

  title() {
    return app.translator.trans('chenlizheme-private-messages.forum.modal.title');
  }

  className() {
    return 'StartConversationModal Modal--medium';
  }

  content() {
    return [
      <div className="Modal-body" onclick={(e) => e.stopImmediatePropagation()}>
        {this.already ? (
          [
            <h2>{app.translator.trans('chenlizheme-private-messages.forum.modal.already', { username: username(this.recpient) })}</h2>,
            <h2>{app.translator.trans('chenlizheme-private-messages.forum.modal.copied', { username: username(this.recpient) })}</h2>,
          ]
        ) : (
          <div>
            <div class="helpText">
              {app.cache.conversationsRecipient !== null
                ? app.translator.trans('chenlizheme-private-messages.forum.modal.help_start', { username: username(app.cache.conversationsRecipient) })
                : app.translator.trans('chenlizheme-private-messages.forum.modal.help')}
            </div>
            <div className="AddRecipientModal-form">
              <RecipientSearch state={app.search} />
              {app.cache.conversationsRecipient !== null ? (
                <div className="AddRecipientModal-form-submit">
                  <textarea
                    value={this.messageContent()}
                    oninput={withAttr('value', this.messageContent)}
                    placeholder={app.translator.trans('chenlizheme-private-messages.forum.chat.text_placeholder')}
                    rows="3"
                  />
                  <Button type="submit" className="Button Button--primary" disabled={!this.messageContent()}>
                    {app.translator.trans('chenlizheme-private-messages.forum.modal.submit')}
                  </Button>
                </div>
              ) : (
                ''
              )}
            </div>
          </div>
        )}
      </div>,
    ];
  }

  onsubmit(e) {
    e.preventDefault();

    const recipient = app.cache.conversationsRecipient;
    this.recpient = recipient;
    app.cache.conversationsRecipient = null;

    app.store
      .createRecord('conversations')
      .save({
        messageContents: this.messageContent(),
        recipient: recipient.id(),
      })
      .then((conversation) => {
        if (!conversation.notNew()) {
          this.conversations.push(conversation);

          // const preconv = app.session.user.conversations();
          // preconv.push(conversation);
          // app.session.user.conversations = Stream(preconv);

          // Need to review Github diff after this point
          m.redraw();
          app.modal.close();
        } else {
          let input = document.createElement('textarea');
          document.body.appendChild(input);
          input.value = this.messageContent();
          input.focus();
          input.select();
          document.execCommand('Copy');
          input.remove();
          this.already = true;
          m.redraw();
        }
      });
  }
}
